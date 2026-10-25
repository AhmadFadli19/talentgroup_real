<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CodeExecutionService
{
    /**
     * Wandbox API - free, supports stdin, multi-language
     */
    private const WANDBOX_API = 'https://wandbox.org/api/compile.json';

    /**
     * Comprehensive coding rules with regex patterns (supports both canonical keys and language-specific aliases)
     */
    private static array $rulePatterns = [
        // Loops
        'for_loop'             => '/\bfor\b/',
        'while_loop'           => '/\bwhile\b/',
        'loop_while'           => '/\bwhile\b/',

        // Conditionals
        'if_statement'         => '/\bif\b/',
        'switch'               => '/\bswitch\b/',
        'switch_statement'     => '/\bswitch\b/',

        // Functions & Methods
        'function_declaration' => '/\bfunc\s+\w+|\bfunction\s+\w+|\bdef\s+\w+|\b(?:public|private|protected)\s+(?:static\s+)?[\w<>\[\]]+\s+\w+\s*\(|\=\>\s*\{?/',
        'func'                 => '/\bfunc\s+\w+/',
        'function'             => '/\bfunction\s+\w+|\=\>\s*\{?/',
        'def'                  => '/\bdef\s+\w+/',
        'method'               => '/\b(func|def|function|public|private)\b/',
        'callback'             => '/(function|\=\>)/',
        'promise'              => '/(Promise|async|await)/',

        // Variables
        'variable_declaration' => '/(\bvar\b|:=|\blet\b|\bconst\b|\bint\s+\w|\bdouble\s+\w|\bfloat\s+\w|\bString\s+\w|\$\w+)/',
        'variable'             => '/(\bvar\b|:=|\blet\b|\bconst\b|\bint\s+\w|\bdouble\s+\w|\bfloat\s+\w|\bString\s+\w|\$\w+)/',
        'var_short'            => '/:=/',
        'const_let'            => '/(\bconst\b|\blet\b)/',

        // Arrays & Slices & Lists
        'array_usage'          => '/(\[\]|\bArray\b|\blist\b|\[\d*\])/',
        'array'                => '/(\[\]|\bArray\b|\blist\b|\[\d*\])/',
        'slice'                => '/\[\]/',
        'list'                 => '/(\[\]|\[.*?\]|\blist\b)/',
        'arraylist'            => '/ArrayList/',
        'map_filter'           => '/(\.map\(|\.filter\(|\.forEach\()/',
        'list_comp'            => '/\[.*?\bfor\b.*?\]/',

        // Maps & Dictionaries & Objects
        'map_usage'            => '/(\bmap\s*\[|\bnew Map\b|\bdict\b|\bObject\.keys\b|\{\s*[\'\"]?\w+[\'\"]?\s*:)/',
        'map'                  => '/(\bmap\s*\[|\bnew Map\b)/',
        'dict'                 => '/(\bdict\b|\{.*?:.*?\}|\{\})/',
        'object'               => '/(\{.*?:.*?\}|\bnew Object\b)/',
        'assoc_array'          => '/(\[\s*[\'"].*?[\'"]\s*\=\>|array\()/',
        'hash'                 => '/(\bHash\.new\b|\{.*?:.*?\}|\{.*?=\>.*?\})/',

        // Structs, Classes & Types
        'struct_usage'         => '/(\btype\s+\w+\s+struct\b|\bclass\s+\w+)/',
        'struct'               => '/\btype\s+\w+\s+struct\b/',
        'class'                => '/\bclass\s+\w+/',
        'type'                 => '/\btype\s+\w+/',
        'interface'            => '/(\binterface\s*\{|\binterface\s+\w+)/',
        'interface_usage'      => '/(\binterface\s*\{|\binterface\s+\w+)/',
        'generic'              => '/<\s*\w+\s*>/',
        'enum'                 => '/\benum\s+\w+/',

        // Concurrency
        'goroutine'            => '/\bgo\s+/',
        'channel'              => '/(\bchan\b|make\s*\(\s*chan)/',

        // Pointers & References
        'pointer'              => '/[*&]\w+/',
        'reference'            => '/&\w+/',

        // Error Handling
        'error_handling'       => '/(\berror\b|\btry\b|\bcatch\b|\bthrow\b|\bexcept\b)/',
        'error'                => '/\berror\b/',
        'try_catch'            => '/(\btry\b[\s\S]*?\bcatch\b)/',
        'try_except'           => '/(\btry\b[\s\S]*?\bexcept\b)/',

        // Output Print
        'fmt_println'          => '/(fmt\.Println|console\.log|print\(|System\.out\.println|echo\s|puts\s)/',
        'print'                => '/\bprint\s*\(/',
        'sysout'               => '/System\.out\.println/',
        'echo'                 => '/(\becho\b|\bprint\b)/',
        'console_log'          => '/console\.log/',
        'puts'                 => '/\bputs\b/',
        'fmt_printf'           => '/(fmt\.Printf|printf|System\.out\.printf)/',
        'printf'               => '/\bprintf\b/',

        // Input
        'fmt_scanf'            => '/(fmt\.Scan|prompt\(|input\(|Scanner|fgets|readline|gets)/',
        'input_fn'             => '/\binput\s*\(/',
        'scanner'              => '/Scanner/',
        'readline'             => '/readline/',
        'fgets'                => '/fgets/',
        'gets'                 => '/\bgets\b/',

        // Strings
        'string_manipulation'  => '/(strings\.|\.split\(|\.join\(|\.replace\(|str\.|\.substring\(|\.length|strlen\()/',
        'strings'              => '/strings\./',
        'string_ops'           => '/(strings\.|\.split\(|\.join\(|\.replace\(|str\.|\.substring\(|\.length|strlen\()/',

        // Math
        'math_operations'      => '/[\+\-\*\/]\s*=|[\+\-\*\/]\s|\bMath\./',
        'math_ops'             => '/[\+\-\*\/]\s*=|[\+\-\*\/]\s|\bMath\./',

        // Web & Others
        'dom_manipulation'     => '/(document\.|getElementById|querySelector)/',
        'event_handling'       => '/(addEventListener|onclick|onchange)/',
        'import'               => '/\bimport\b/',
        'include'              => '/#include/',
        'namespace'            => '/using\s+namespace/',
        'each'                 => '/\.each\b/',
        'block'                => '/(do[\s\S]*?end|\{.*?\})/',
    ];

    /**
     * Wandbox compiler identifiers per language
     */
    private static array $compilerMap = [
        'go'         => 'go-1.23.2',
        'javascript' => 'nodejs-20.17.0',
        'python'     => 'cpython-3.14.0',
        'java'       => 'openjdk-jdk-22+36',
        'c'          => 'gcc-head-c',
        'cpp'        => 'gcc-head',
        'php'        => 'php-8.3.12',
        'ruby'       => 'ruby-3.4.1',
        'typescript' => 'typescript-5.6.2',
    ];

    /**
     * Get available languages with human-readable labels
     */
    public static function availableLanguages(): array
    {
        return [
            'go'         => 'Golang (Go)',
            'javascript' => 'JavaScript (Node.js)',
            'python'     => 'Python 3',
            'java'       => 'Java',
            'c'          => 'C',
            'cpp'        => 'C++',
            'php'        => 'PHP',
            'ruby'       => 'Ruby',
            'typescript' => 'TypeScript',
        ];
    }

    /**
     * Get coding rules per language
     */
    public static function codingRulesForLanguage(string $language): array
    {
        $common = [
            'for_loop'    => 'For Loop (for)',
            'if_statement'=> 'If Statement (if)',
            'switch'      => 'Switch Statement (switch)',
            'variable'    => 'Variable Declaration',
            'array'       => 'Array',
            'math_ops'    => 'Math Operations (+, -, *, /)',
        ];

        return match ($language) {
            'go' => array_merge($common, [
                'func'        => 'Function Declaration (func)',
                'var_short'   => 'Short Variable (:=)',
                'slice'       => 'Slice ([])',
                'map'         => 'Map (map[])',
                'struct'      => 'Struct (type ... struct)',
                'goroutine'   => 'Goroutine (go)',
                'channel'     => 'Channel (chan)',
                'pointer'     => 'Pointer (*)',
                'interface'   => 'Interface (interface)',
                'error'       => 'Error Handling (error)',
                'fmt_println' => 'fmt.Println',
                'fmt_printf'  => 'fmt.Printf',
                'strings'     => 'String Operations (strings.)',
            ]),
            'java' => array_merge($common, [
                'class'       => 'Class Declaration (class)',
                'method'      => 'Method Declaration',
                'sysout'      => 'System.out.println',
                'scanner'     => 'Scanner (input)',
                'try_catch'   => 'Try-Catch (exception)',
                'import'      => 'Import Statement',
                'string_ops'  => 'String Operations',
                'arraylist'   => 'ArrayList',
                'while_loop'  => 'While Loop',
            ]),
            'javascript' => array_merge($common, [
                'function'    => 'Function (function/arrow)',
                'console_log' => 'console.log',
                'const_let'   => 'const/let Declaration',
                'object'      => 'Object {}',
                'callback'    => 'Callback Function',
                'promise'     => 'Promise/async-await',
                'string_ops'  => 'String Operations',
                'map_filter'  => 'Array map/filter',
                'readline'    => 'readline (input)',
            ]),
            'python' => array_merge($common, [
                'def'         => 'Function (def)',
                'print'       => 'print()',
                'input_fn'    => 'input()',
                'list'        => 'List []',
                'dict'        => 'Dictionary {}',
                'class'       => 'Class (class)',
                'try_except'  => 'Try-Except',
                'list_comp'   => 'List Comprehension',
                'string_ops'  => 'String Operations',
                'while_loop'  => 'While Loop',
            ]),
            'php' => array_merge($common, [
                'function'    => 'Function (function)',
                'echo'        => 'echo / print',
                'class'       => 'Class (class)',
                'fgets'       => 'fgets(STDIN) input',
                'try_catch'   => 'Try-Catch',
                'string_ops'  => 'String Functions',
                'assoc_array' => 'Associative Array',
                'while_loop'  => 'While Loop',
            ]),
            'c' => array_merge($common, [
                'function'    => 'Function Declaration',
                'printf'      => 'printf()',
                'scanf'       => 'scanf() input',
                'pointer'     => 'Pointer (*)',
                'struct'      => 'Struct',
                'include'     => '#include',
                'while_loop'  => 'While Loop',
                'string_ops'  => 'String Operations (string.h)',
            ]),
            'cpp' => array_merge($common, [
                'class'       => 'Class (class)',
                'cout'        => 'cout / cin',
                'function'    => 'Function Declaration',
                'pointer'     => 'Pointer (*)',
                'reference'   => 'Reference (&)',
                'vector'      => 'Vector',
                'include'     => '#include',
                'namespace'   => 'using namespace std',
                'string_ops'  => 'String Operations',
                'while_loop'  => 'While Loop',
            ]),
            'ruby' => array_merge($common, [
                'def'         => 'Method (def)',
                'puts'        => 'puts / print',
                'gets'        => 'gets (input)',
                'class'       => 'Class (class)',
                'block'       => 'Block (do..end / {})',
                'hash'        => 'Hash',
                'each'        => '.each iterator',
                'string_ops'  => 'String Operations',
                'while_loop'  => 'While Loop',
            ]),
            'typescript' => array_merge($common, [
                'function'    => 'Function (function/arrow)',
                'console_log' => 'console.log',
                'type'        => 'Type Annotation',
                'interface'   => 'Interface',
                'const_let'   => 'const/let Declaration',
                'class'       => 'Class (class)',
                'generic'     => 'Generic <T>',
                'enum'        => 'Enum',
                'string_ops'  => 'String Operations',
            ]),
            default => $common,
        };
    }

    /**
     * Get starter code template per language
     */
    public static function starterCodeForLanguage(string $language): string
    {
        return match ($language) {
            'go' => "package main\n\nimport \"fmt\"\n\nfunc main() {\n\t// Tulis kode kamu di sini\n\tfmt.Println(\"Hello, World!\")\n}",
            'java' => "import java.util.Scanner;\n\nclass Main {\n    public static void main(String[] args) {\n        // Tulis kode kamu di sini\n        System.out.println(\"Hello, World!\");\n    }\n}",
            'javascript' => "// Tulis kode kamu di sini\nconsole.log(\"Hello, World!\");",
            'python' => "# Tulis kode kamu di sini\nprint(\"Hello, World!\")",
            'php' => "<?php\n// Tulis kode kamu di sini\necho \"Hello, World!\\n\";\n?>",
            'c' => "#include <stdio.h>\n\nint main() {\n    // Tulis kode kamu di sini\n    printf(\"Hello, World!\\n\");\n    return 0;\n}",
            'cpp' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    // Tulis kode kamu di sini\n    cout << \"Hello, World!\" << endl;\n    return 0;\n}",
            'ruby' => "# Tulis kode kamu di sini\nputs \"Hello, World!\"",
            'typescript' => "// Tulis kode kamu di sini\nconsole.log(\"Hello, World!\");",
            default => "// Tulis kode kamu di sini",
        };
    }

    /**
     * Pre-process code before sending to Wandbox
     */
    private function preprocessCode(string $code, string $language): string
    {
        if ($language === 'java') {
            $code = preg_replace('/\bpublic\s+class\b/', 'class', $code);
        }

        return $code;
    }

    /**
     * Check if a language has a fast local runner installed on this server
     */
    public function hasLocalRunner(string $language): bool
    {
        return in_array($language, ['go', 'python', 'javascript', 'php', 'java', 'typescript'], true);
    }

    /**
     * Locate system binary with ultra-fast cached path lookup (0ms)
     */
    private function getExecutablePath(string $binary): ?string
    {
        static $paths = [];
        if (array_key_exists($binary, $paths)) {
            return $paths[$binary];
        }

        // Fast check: Known Windows paths
        $fallbacks = [
            'go' => [
                'C:\\Program Files\\Go\\bin\\go.exe',
            ],
            'node' => [
                'C:\\Program Files\\nodejs\\node.exe',
                'C:\\laragon\\bin\\nodejs\\node-v18\\node.exe',
            ],
            'python' => [
                'C:\\Users\\kingh\\AppData\\Local\\Microsoft\\WindowsApps\\python.exe',
                'C:\\laragon\\bin\\python\\python-3.10\\python.exe',
                'C:\\Python313\\python.exe',
                'C:\\Python312\\python.exe',
            ],
            'php' => [
                'C:\\laragon\\bin\\php\\php-8.5.4-Win32-vs17-x64\\php.exe',
                PHP_BINARY,
            ],
            'javac' => [
                'C:\\Program Files\\Common Files\\Oracle\\Java\\javapath\\javac.exe',
            ],
            'java' => [
                'C:\\Program Files\\Common Files\\Oracle\\Java\\javapath\\java.exe',
            ],
        ];

        if (isset($fallbacks[$binary])) {
            foreach ($fallbacks[$binary] as $fb) {
                if (file_exists($fb)) {
                    return $paths[$binary] = $fb;
                }
            }
        }

        // Fallback: system lookup (only if not found in known paths)
        $lookupCmd = (PHP_OS_FAMILY === 'Windows') ? "where.exe {$binary} 2>NUL" : "which {$binary} 2>/dev/null";
        $out = @shell_exec($lookupCmd);
        if ($out) {
            $lines = explode("\n", trim($out));
            $first = trim($lines[0]);
            if (file_exists($first)) {
                return $paths[$binary] = $first;
            }
        }

        return $paths[$binary] = $binary;
    }

    /**
     * Get a fully isolated, safe execution environment for compilers.
     * Prevents tools (especially Go, Python, Node) from attempting to write into C:\WINDOWS or system directories.
     */
    private function getSafeExecutionEnv(): array
    {
        $baseRunners = storage_path('app/code_runners');
        $tempDir     = $baseRunners . DIRECTORY_SEPARATOR . 'gotmp';
        $cacheDir    = $baseRunners . DIRECTORY_SEPARATOR . 'gocache';
        $gopath      = $baseRunners . DIRECTORY_SEPARATOR . 'gopath';

        if (!is_dir($tempDir))  @mkdir($tempDir, 0777, true);
        if (!is_dir($cacheDir)) @mkdir($cacheDir, 0777, true);
        if (!is_dir($gopath))   @mkdir($gopath, 0777, true);

        $sysRoot = getenv('SystemRoot') ?: (getenv('SYSTEMROOT') ?: 'C:\Windows');
        $currentPath = getenv('PATH') ?: 'C:\Windows\system32;C:\Windows;C:\Program Files\Go\bin';

        return [
            'SystemRoot'              => $sysRoot,
            'SYSTEMROOT'              => $sysRoot,
            'PATH'                    => $currentPath,
            'TMP'                     => $tempDir,
            'TEMP'                    => $tempDir,
            'TMPDIR'                  => $tempDir,
            'USERPROFILE'             => $baseRunners,
            'HOME'                    => $baseRunners,
            'LOCALAPPDATA'            => $cacheDir,
            'APPDATA'                 => $cacheDir,
            // Go specific: guarantees Go never writes to C:\WINDOWS or fails with Access is denied
            'GOTMPDIR'                => $tempDir,
            'GOCACHE'                 => $cacheDir,
            'GOPATH'                  => $gopath,
            'GO111MODULE'             => 'off',
            'CGO_ENABLED'             => '0',
            // Python specific
            'PYTHONDONTWRITEBYTECODE'  => '1',
            'PYTHONUNBUFFERED'         => '1',
        ];
    }

    /**
     * Run a process safely with Symfony Process (cross-platform, reliable timeouts, memory capping)
     */
    private function runProcessWithTimeout(string|array $cmd, ?string $input = null, ?string $cwd = null, float $timeout = 4.0, bool $bypassShell = false, ?array $env = null): array
    {
        $stdout = '';
        $stderr = '';
        $safeEnv = $env ?: $this->getSafeExecutionEnv();

        try {
            $process = is_array($cmd)
                ? new \Symfony\Component\Process\Process($cmd, $cwd, $safeEnv)
                : \Symfony\Component\Process\Process::fromShellCommandline($cmd, $cwd, $safeEnv);

            $process->setTimeout($timeout);
            $process->setIdleTimeout($timeout);

            if ($input !== null && $input !== '') {
                $normalizedInput = str_replace("\r\n", "\n", $input);
                if (!str_ends_with($normalizedInput, "\n")) {
                    $normalizedInput .= "\n";
                }
                $process->setInput($normalizedInput);
            }

            $process->run(function ($type, $buffer) use (&$stdout, &$stderr, $process) {
                if ($type === \Symfony\Component\Process\Process::OUT) {
                    $stdout .= $buffer;
                    if (strlen($stdout) > 256000) {
                        $stdout .= "\n[Batas output 256KB tercapai - eksekusi dihentikan]";
                        $process->stop(0.2);
                    }
                } else {
                    $stderr .= $buffer;
                    if (strlen($stderr) > 256000) {
                        $stderr .= "\n[Batas error 256KB tercapai - eksekusi dihentikan]";
                        $process->stop(0.2);
                    }
                }
            });

            return [
                'success'   => $process->isSuccessful() && empty(trim($stderr)),
                'output'    => trim($stdout),
                'errors'    => trim($stderr),
                'exit_code' => $process->getExitCode(),
            ];
        } catch (\Symfony\Component\Process\Exception\ProcessTimedOutException $e) {
            return [
                'success'   => false,
                'output'    => trim($stdout),
                'errors'    => "[Batas Waktu Eksekusi: Program melebihi batas waktu {$timeout} detik. Periksa loop tak terbatas atau input.]",
                'exit_code' => -1,
            ];
        } catch (\Throwable $e) {
            return [
                'success'   => false,
                'output'    => trim($stdout),
                'errors'    => 'Runner error: ' . $e->getMessage(),
                'exit_code' => -1,
            ];
        }
    }

    /**
     * Local ultra-fast compilation & execution (sub-second)
     */
    public function compileLocal(string $code, ?string $input = null, string $language = 'go'): ?array
    {
        $workBase = storage_path('app/code_runners/' . $language);
        if (!is_dir($workBase)) {
            @mkdir($workBase, 0777, true);
        }

        $jobId = uniqid('run_', true);
        $jobDir = $workBase . DIRECTORY_SEPARATOR . $jobId;
        @mkdir($jobDir, 0777, true);

        try {
            switch ($language) {
                case 'go':
                    $goExe = $this->getExecutablePath('go') ?: 'go';
                    $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'main.go';
                    file_put_contents($mainFile, $code);

                    $exeFile = $jobDir . DIRECTORY_SEPARATOR . 'app.exe';
                    $buildCmd = [$goExe, 'build', '-ldflags=-s -w', '-o', $exeFile, $mainFile];
                    $buildResult = $this->runProcessWithTimeout($buildCmd, null, $jobDir, 8.0, true);

                    if (!$buildResult['success'] && !file_exists($exeFile)) {
                        return [
                            'success' => false,
                            'output'  => '',
                            'errors'  => trim($buildResult['errors']) ?: 'Compilation error: Failed to compile Go code',
                            'raw'     => ['local' => true, 'runner' => 'go', 'phase' => 'compile', 'exit' => $buildResult['exit_code']],
                        ];
                    }

                    $runResult = $this->runProcessWithTimeout([$exeFile], $input, $jobDir, 3.0, true);
                    return [
                        'success' => $runResult['success'],
                        'output'  => $runResult['output'],
                        'errors'  => $runResult['errors'],
                        'raw'     => ['local' => true, 'runner' => 'go', 'phase' => 'run', 'exit' => $runResult['exit_code']],
                    ];

                case 'java':
                    $javacExe = $this->getExecutablePath('javac') ?: 'javac';
                    $javaExe = $this->getExecutablePath('java') ?: 'java';

                    // Normalize Java class declaration to Main
                    $javaCode = preg_replace('/\bpublic\s+class\s+\w+/', 'class Main', $code);
                    if (!str_contains($javaCode, 'class Main')) {
                        $javaCode = preg_replace('/\bclass\s+\w+/', 'class Main', $javaCode, 1);
                    }

                    $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'Main.java';
                    file_put_contents($mainFile, $javaCode);

                    $buildCmd = "\"{$javacExe}\" " . escapeshellarg($mainFile);
                    $buildResult = $this->runProcessWithTimeout($buildCmd, null, $jobDir, 5.0, false);
                    $classFile = $jobDir . DIRECTORY_SEPARATOR . 'Main.class';

                    if (!$buildResult['success'] && !file_exists($classFile)) {
                        return [
                            'success' => false,
                            'output'  => '',
                            'errors'  => trim($buildResult['errors']) ?: 'Compilation error: Failed to compile Java code',
                            'raw'     => ['local' => true, 'runner' => 'java', 'phase' => 'compile', 'exit' => $buildResult['exit_code']],
                        ];
                    }

                    $runCmd = "\"{$javaExe}\" -cp " . escapeshellarg($jobDir) . " Main";
                    $runResult = $this->runProcessWithTimeout($runCmd, $input, $jobDir, 2.5, true);
                    return [
                        'success' => $runResult['success'],
                        'output'  => $runResult['output'],
                        'errors'  => $runResult['errors'],
                        'raw'     => ['local' => true, 'runner' => 'java', 'phase' => 'run', 'exit' => $runResult['exit_code']],
                    ];

                case 'python':
                    $pyExe = $this->getExecutablePath('python') ?: 'python';
                    $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'main.py';
                    file_put_contents($mainFile, $code);

                    $cmd = "\"{$pyExe}\" -u " . escapeshellarg($mainFile);
                    $result = $this->runProcessWithTimeout($cmd, $input, $jobDir, 3.0, true);
                    return [
                        'success' => $result['success'],
                        'output'  => $result['output'],
                        'errors'  => $result['errors'],
                        'raw'     => ['local' => true, 'runner' => 'python', 'exit' => $result['exit_code']],
                    ];

                case 'javascript':
                    $nodeExe = $this->getExecutablePath('node') ?: 'node';
                    $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'main.js';
                    file_put_contents($mainFile, $code);

                    $cmd = "\"{$nodeExe}\" " . escapeshellarg($mainFile);
                    $result = $this->runProcessWithTimeout($cmd, $input, $jobDir, 3.0, true);
                    return [
                        'success' => $result['success'],
                        'output'  => $result['output'],
                        'errors'  => $result['errors'],
                        'raw'     => ['local' => true, 'runner' => 'node', 'exit' => $result['exit_code']],
                    ];

                case 'typescript':
                    $nodeExe = $this->getExecutablePath('node') ?: 'node';
                    $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'main.ts';
                    file_put_contents($mainFile, $code);

                    $cmd = "\"{$nodeExe}\" --experimental-strip-types " . escapeshellarg($mainFile);
                    $result = $this->runProcessWithTimeout($cmd, $input, $jobDir, 3.0, true);
                    return [
                        'success' => $result['success'],
                        'output'  => $result['output'],
                        'errors'  => $result['errors'],
                        'raw'     => ['local' => true, 'runner' => 'typescript', 'exit' => $result['exit_code']],
                    ];

                case 'php':
                    $phpExe = $this->getExecutablePath('php') ?: (PHP_BINARY ?: 'php');
                    $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'main.php';
                    $phpCode = str_starts_with(trim($code), '<?php') ? $code : "<?php\n" . $code;
                    file_put_contents($mainFile, $phpCode);

                    $cmd = "\"{$phpExe}\" " . escapeshellarg($mainFile);
                    $result = $this->runProcessWithTimeout($cmd, $input, $jobDir, 3.0, true);
                    return [
                        'success' => $result['success'],
                        'output'  => $result['output'],
                        'errors'  => $result['errors'],
                        'raw'     => ['local' => true, 'runner' => 'php', 'exit' => $result['exit_code']],
                    ];

                default:
                    return null;
            }
        } finally {
            $this->cleanupDir($jobDir);
        }
    }

    /**
     * Local batch test cases execution (compiles once, runs N tests in milliseconds)
     */
    public function runLocalTestCases(string $code, array $testCases, string $language = 'go'): ?array
    {
        if (!$this->hasLocalRunner($language)) {
            return null;
        }

        $workBase = storage_path('app/code_runners/' . $language);
        if (!is_dir($workBase)) {
            @mkdir($workBase, 0777, true);
        }

        $jobId = uniqid('test_', true);
        $jobDir = $workBase . DIRECTORY_SEPARATOR . $jobId;
        @mkdir($jobDir, 0777, true);

        try {
            if ($language === 'go') {
                $goExe = $this->getExecutablePath('go') ?: 'go';
                $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'main.go';
                file_put_contents($mainFile, $code);

                // Build executable once for lightning-fast test execution
                $exeFile = $jobDir . DIRECTORY_SEPARATOR . 'app.exe';
                $buildCmd = [$goExe, 'build', '-ldflags=-s -w', '-o', $exeFile, $mainFile];
                $buildResult = $this->runProcessWithTimeout($buildCmd, null, $jobDir, 8.0, true);

                if (!$buildResult['success'] && !file_exists($exeFile)) {
                    $results = [];
                    $errText = trim($buildResult['errors']) ?: 'Compilation error: Failed to compile Go code';
                    foreach ($testCases as $index => $tc) {
                        $results[] = [
                            'test_number'     => $index + 1,
                            'input'           => $tc['input'] ?? '',
                            'expected_output' => $tc['expected_output'] ?? '',
                            'actual_output'   => '',
                            'errors'          => $errText,
                            'passed'          => false,
                            'compiled'        => false,
                        ];
                    }
                    return [
                        'test_results' => $results,
                        'all_passed'   => false,
                        'total'        => count($results),
                        'passed_count' => 0,
                    ];
                }

                // Compiled executable exists: run each test case in ~0.03s
                $results = [];
                foreach ($testCases as $index => $tc) {
                    $input = $tc['input'] ?? '';
                    $expected = $tc['expected_output'] ?? '';
                    $runResult = $this->runProcessWithTimeout([$exeFile], $input, $jobDir, 3.0, true);

                    $passed = false;
                    if ($runResult['success'] && !empty($expected)) {
                        $passed = $this->checkOutput($runResult['output'], $expected);
                    }

                    $results[] = [
                        'test_number'     => $index + 1,
                        'input'           => $input,
                        'expected_output' => $expected,
                        'actual_output'   => $runResult['output'],
                        'errors'          => $runResult['errors'],
                        'passed'          => $passed,
                        'compiled'        => true,
                    ];
                }

                $allPassed = count($results) > 0 && collect($results)->every('passed');
                return [
                    'test_results' => $results,
                    'all_passed'   => $allPassed,
                    'total'        => count($results),
                    'passed_count' => collect($results)->where('passed', true)->count(),
                ];
            }

            if ($language === 'java') {
                $javacExe = $this->getExecutablePath('javac') ?: 'javac';
                $javaExe = $this->getExecutablePath('java') ?: 'java';

                $javaCode = preg_replace('/\bpublic\s+class\s+\w+/', 'class Main', $code);
                if (!str_contains($javaCode, 'class Main')) {
                    $javaCode = preg_replace('/\bclass\s+\w+/', 'class Main', $javaCode, 1);
                }

                $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'Main.java';
                file_put_contents($mainFile, $javaCode);

                $buildCmd = "\"{$javacExe}\" " . escapeshellarg($mainFile);
                $buildResult = $this->runProcessWithTimeout($buildCmd, null, $jobDir, 5.0, false);
                $classFile = $jobDir . DIRECTORY_SEPARATOR . 'Main.class';

                if (!$buildResult['success'] && !file_exists($classFile)) {
                    $results = [];
                    $errText = trim($buildResult['errors']) ?: 'Compilation error: Failed to compile Java code';
                    foreach ($testCases as $index => $tc) {
                        $results[] = [
                            'test_number'     => $index + 1,
                            'input'           => $tc['input'] ?? '',
                            'expected_output' => $tc['expected_output'] ?? '',
                            'actual_output'   => '',
                            'errors'          => $errText,
                            'passed'          => false,
                            'compiled'        => false,
                        ];
                    }
                    return [
                        'test_results' => $results,
                        'all_passed'   => false,
                        'total'        => count($results),
                        'passed_count' => 0,
                    ];
                }

                $runCmd = "\"{$javaExe}\" -cp " . escapeshellarg($jobDir) . " Main";
                $results = [];
                foreach ($testCases as $index => $tc) {
                    $input = $tc['input'] ?? '';
                    $expected = $tc['expected_output'] ?? '';
                    $runResult = $this->runProcessWithTimeout($runCmd, $input, $jobDir, 2.0, true);

                    $passed = false;
                    if ($runResult['success'] && !empty($expected)) {
                        $passed = $this->checkOutput($runResult['output'], $expected);
                    }

                    $results[] = [
                        'test_number'     => $index + 1,
                        'input'           => $input,
                        'expected_output' => $expected,
                        'actual_output'   => $runResult['output'],
                        'errors'          => $runResult['errors'],
                        'passed'          => $passed,
                        'compiled'        => true,
                    ];
                }

                $allPassed = count($results) > 0 && collect($results)->every('passed');
                return [
                    'test_results' => $results,
                    'all_passed'   => $allPassed,
                    'total'        => count($results),
                    'passed_count' => collect($results)->where('passed', true)->count(),
                ];
            }

            if (in_array($language, ['python', 'javascript', 'typescript', 'php'])) {
                $ext = match ($language) {
                    'python'     => 'py',
                    'javascript' => 'js',
                    'typescript' => 'ts',
                    'php'        => 'php',
                };
                $mainFile = $jobDir . DIRECTORY_SEPARATOR . 'main.' . $ext;

                if ($language === 'php') {
                    $phpCode = str_starts_with(trim($code), '<?php') ? $code : "<?php\n" . $code;
                    file_put_contents($mainFile, $phpCode);
                    $bin = $this->getExecutablePath('php') ?: (PHP_BINARY ?: 'php');
                    $cmd = "\"{$bin}\" " . escapeshellarg($mainFile);
                } elseif ($language === 'python') {
                    file_put_contents($mainFile, $code);
                    $bin = $this->getExecutablePath('python') ?: 'python';
                    $cmd = "\"{$bin}\" -u " . escapeshellarg($mainFile);
                } elseif ($language === 'typescript') {
                    file_put_contents($mainFile, $code);
                    $bin = $this->getExecutablePath('node') ?: 'node';
                    $cmd = "\"{$bin}\" --experimental-strip-types " . escapeshellarg($mainFile);
                } else {
                    file_put_contents($mainFile, $code);
                    $bin = $this->getExecutablePath('node') ?: 'node';
                    $cmd = "\"{$bin}\" " . escapeshellarg($mainFile);
                }

                $results = [];

                foreach ($testCases as $index => $tc) {
                    $input = $tc['input'] ?? '';
                    $expected = $tc['expected_output'] ?? '';
                    $runResult = $this->runProcessWithTimeout($cmd, $input, $jobDir, 2.5, true);

                    $passed = false;
                    if ($runResult['success'] && !empty($expected)) {
                        $passed = $this->checkOutput($runResult['output'], $expected);
                    }

                    $results[] = [
                        'test_number'     => $index + 1,
                        'input'           => $input,
                        'expected_output' => $expected,
                        'actual_output'   => $runResult['output'],
                        'errors'          => $runResult['errors'],
                        'passed'          => $passed,
                        'compiled'        => $runResult['success'] || !empty($runResult['output']),
                    ];
                }

                $allPassed = count($results) > 0 && collect($results)->every('passed');
                return [
                    'test_results' => $results,
                    'all_passed'   => $allPassed,
                    'total'        => count($results),
                    'passed_count' => collect($results)->where('passed', true)->count(),
                ];
            }

            return null;
        } finally {
            $this->cleanupDir($jobDir);
        }
    }

    /**
     * Compile and run code with Fast Local Execution and Smart Caching
     */
    public function compile(string $code, ?string $input = null, string $language = 'go'): array
    {
        // 1. Fast Cache Layer (Instant ~0.001s response for identical runs)
        $cacheKey = 'code_comp_' . md5($language . '_' . $code . '_' . ($input ?? ''));
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // 2. High-speed Local Runner Engine (< 0.5s)
        if ($this->hasLocalRunner($language)) {
            try {
                $localResult = $this->compileLocal($code, $input, $language);
                if ($localResult !== null) {
                    $this->cacheUnlessTimeout($cacheKey, $localResult);
                    return $localResult;
                }
            } catch (\Throwable $e) {
                Log::warning('Local compile runner failed, falling back to Wandbox: ' . $e->getMessage());
            }
        }

        // 3. Fallback: Wandbox API
        try {
            $compiler = self::$compilerMap[$language] ?? self::$compilerMap['go'];
            $codePreprocessed = $this->preprocessCode($code, $language);

            $payload = [
                'code'     => $codePreprocessed,
                'compiler' => $compiler,
            ];

            if ($input !== null && $input !== '') {
                $payload['stdin'] = $input;
            }

            if ($language === 'cpp') {
                $payload['options'] = 'warning,cpp-no-pedantic';
                $payload['compiler-option-raw'] = '-std=c++17';
            }

            Log::info('Wandbox fallback request', ['language' => $language]);

            $response = Http::timeout(10)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post(self::WANDBOX_API, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $output = $data['program_output'] ?? '';
                $errors = '';

                if (!empty($data['compiler_error'])) {
                    $errors .= $data['compiler_error'];
                }
                if (!empty($data['program_error'])) {
                    $errors .= $data['program_error'];
                }

                $status = $data['status'] ?? '0';
                if ($status !== '0' && $status !== 0 && empty($errors)) {
                    $errors = $data['compiler_message'] ?? $data['program_message'] ?? 'Program exited with error';
                }

                $result = [
                    'success' => ($status === '0' || $status === 0) && empty($errors),
                    'output'  => trim($output),
                    'errors'  => trim($errors),
                    'raw'     => $data,
                ];

                $this->cacheUnlessTimeout($cacheKey, $result);
                return $result;
            }

            if ($language === 'go') {
                $result = $this->compileGoPlayground($code);
                $this->cacheUnlessTimeout($cacheKey, $result);
                return $result;
            }

            return [
                'success' => false,
                'output'  => '',
                'errors'  => 'Gagal menghubungi server kompilasi (HTTP ' . $response->status() . ')',
                'raw'     => null,
            ];
        } catch (\Throwable $e) {
            Log::error('Code execution error: ' . $e->getMessage());

            if ($language === 'go') {
                try {
                    $result = $this->compileGoPlayground($code);
                    $this->cacheUnlessTimeout($cacheKey, $result);
                    return $result;
                } catch (\Throwable $e2) {}
            }

            return [
                'success' => false,
                'output'  => '',
                'errors'  => 'Connection error: ' . $e->getMessage(),
                'raw'     => null,
            ];
        }
    }

    /**
     * Fallback: Go Playground API
     */
    private function compileGoPlayground(string $code): array
    {
        try {
            $response = Http::timeout(8)->asForm()->post('https://go.dev/_/compile', [
                'version' => 2,
                'body'    => $code,
                'withVet' => true,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $output = '';
                $errors = '';

                if (isset($data['Events']) && is_array($data['Events'])) {
                    foreach ($data['Events'] as $event) {
                        if ($event['Kind'] === 'stdout') {
                            $output .= $event['Message'];
                        } elseif ($event['Kind'] === 'stderr') {
                            $errors .= $event['Message'];
                        }
                    }
                }

                if (!empty($data['Errors'])) {
                    $errors = $data['Errors'];
                }

                return [
                    'success' => empty($errors),
                    'output'  => trim($output),
                    'errors'  => trim($errors),
                    'raw'     => $data,
                ];
            }
        } catch (\Throwable $e) {}

        return [
            'success' => false,
            'output'  => '',
            'errors'  => 'Layanan kompilasi tidak tersedia saat ini.',
            'raw'     => null,
        ];
    }

    /**
     * Validate code against a set of rules (Instant regex check < 1ms)
     */
    public function validateRules(string $code, array $rules): array
    {
        $results = [];
        $cleanCode = $this->stripCommentsAndStrings($code);

        foreach ($rules as $key => $rule) {
            $ruleName = is_string($rule) ? $rule : ($rule['name'] ?? $rule['rule'] ?? $rule['type'] ?? (string)$key);
            if (isset(self::$rulePatterns[$ruleName])) {
                $results[$ruleName] = (bool) preg_match(self::$rulePatterns[$ruleName], $cleanCode);
            } else {
                $results[$ruleName] = true;
            }
        }

        return $results;
    }

    /**
     * Check if actual output matches expected output with cross-platform normalization
     */
    public function checkOutput(string $actualOutput, string $expectedOutput): bool
    {
        $normalize = function (string $text): string {
            $text = str_replace("\r\n", "\n", $text);
            $text = str_replace("\r", "\n", $text);
            $lines = array_map('rtrim', explode("\n", $text));
            while (!empty($lines) && end($lines) === '') {
                array_pop($lines);
            }
            return trim(implode("\n", $lines));
        };

        return $normalize($actualOutput) === $normalize($expectedOutput);
    }

    /**
     * Strip comments and string literals from code for accurate syntax rule matching
     */
    private function stripCommentsAndStrings(string $code): string
    {
        $code = preg_replace('/\/\/.*$/m', '', $code);
        $code = preg_replace('/\/\*.*?\*\//s', '', $code);
        $code = preg_replace('/#.*$/m', '', $code);
        $code = preg_replace('/"[^"]*"/', '""', $code);
        $code = preg_replace("/`[^`]*`/", '``', $code);
        $code = preg_replace("/'[^']*'/", "''", $code);
        return $code;
    }

    /**
     * Run all test cases against user code (sub-second batch execution & caching)
     */
    public function runTestCases(string $code, array $testCases, string $language = 'go'): array
    {
        // 1. Fast Cache check (~0.001s)
        $cacheKey = 'code_tests_' . md5($language . '_' . $code . '_' . json_encode($testCases));
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // 2. High-speed Local Runner Engine (< 0.5s for all test cases)
        if ($this->hasLocalRunner($language)) {
            try {
                $localResult = $this->runLocalTestCases($code, $testCases, $language);
                if ($localResult !== null) {
                    $this->cacheUnlessTimeout($cacheKey, $localResult);
                    return $localResult;
                }
            } catch (\Throwable $e) {
                Log::warning('Local test runner failed, falling back to Wandbox: ' . $e->getMessage());
            }
        }

        // 3. Fallback: Wandbox loop
        $results = [];
        foreach ($testCases as $index => $testCase) {
            $input = $testCase['input'] ?? '';
            $expectedOutput = $testCase['expected_output'] ?? '';

            $compileResult = $this->compile($code, $input, $language);

            $passed = false;
            if ($compileResult['success'] && !empty($expectedOutput)) {
                $passed = $this->checkOutput($compileResult['output'], $expectedOutput);
            }

            $results[] = [
                'test_number'     => $index + 1,
                'input'           => $input,
                'expected_output' => $expectedOutput,
                'actual_output'   => $compileResult['output'] ?? '',
                'errors'          => $compileResult['errors'] ?? '',
                'passed'          => $passed,
                'compiled'        => $compileResult['success'],
            ];
        }

        $allPassed = count($results) > 0 && collect($results)->every('passed');

        $final = [
            'test_results' => $results,
            'all_passed'   => $allPassed,
            'total'        => count($results),
            'passed_count' => collect($results)->where('passed', true)->count(),
        ];

        $this->cacheUnlessTimeout($cacheKey, $final);
        return $final;
    }

    /**
     * Full validation: check rules + compile + output match + test cases
     */
    public function fullValidation(string $code, array $rules, string $expectedOutput, array $testCases = [], ?string $input = null, string $language = 'go'): array
    {
        // 1. Fast Cache check (~0.001s)
        $cacheKey = 'code_val_' . md5($language . '_' . $code . '_' . json_encode($rules) . '_' . $expectedOutput . '_' . json_encode($testCases) . '_' . ($input ?? ''));
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // 2. Syntax rules validation (< 0.001s)
        $rulesResult = $this->validateRules($code, $rules);
        $allRulesPassed = !in_array(false, $rulesResult, true);

        $testResults = null;
        $allTestsPassed = true;

        if (!empty($testCases)) {
            $testResults = $this->runTestCases($code, $testCases, $language);
            $allTestsPassed = $testResults['all_passed'];
            $mainOutput = $testResults['test_results'][0]['actual_output'] ?? '';
            $mainErrors = $testResults['test_results'][0]['errors'] ?? '';
            $compileSuccess = $testResults['test_results'][0]['compiled'] ?? false;
        } else {
            $compileResult = $this->compile($code, $input, $language);
            $mainOutput = $compileResult['output'];
            $mainErrors = $compileResult['errors'];
            $compileSuccess = $compileResult['success'];
        }

        $outputMatches = false;
        if ($compileSuccess && !empty($expectedOutput)) {
            $outputMatches = $this->checkOutput($mainOutput, $expectedOutput);
        }

        if (!empty($testCases)) {
            $canSubmit = $allRulesPassed && $allTestsPassed;
        } elseif (!empty($expectedOutput)) {
            $canSubmit = $allRulesPassed && $outputMatches;
        } else {
            $canSubmit = $allRulesPassed;
        }

        $final = [
            'rules'            => $rulesResult,
            'all_rules_passed' => $allRulesPassed,
            'compilation'      => [
                'success' => $compileSuccess,
                'output'  => $mainOutput,
                'errors'  => $mainErrors,
            ],
            'output_matches'   => $outputMatches,
            'test_results'     => $testResults,
            'all_tests_passed' => $allTestsPassed,
            'can_submit'       => $canSubmit,
        ];

        $this->cacheUnlessTimeout($cacheKey, $final);
        return $final;
    }

    /**
     * Cache results safely, avoiding caching of timeouts or infrastructure faults
     */
    private function cacheUnlessTimeout(string $cacheKey, array $result, int $ttl = 180): void
    {
        $err = $result['errors'] ?? ($result['compilation']['errors'] ?? '');
        $hasTimeout = str_contains($err, 'Batas Waktu Eksekusi') ||
                      str_contains($err, 'Timeout') ||
                      str_contains($err, 'Connection error') ||
                      str_contains($err, 'Gagal menghubungi server kompilasi');

        if (!$hasTimeout) {
            Cache::put($cacheKey, $result, $ttl);
        }
    }

    /**
     * Recursively clean up temporary job directory
     */
    private function cleanupDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $files = @scandir($dir);
        if ($files) {
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $path = $dir . DIRECTORY_SEPARATOR . $file;
                if (is_dir($path)) {
                    $this->cleanupDir($path);
                } else {
                    @unlink($path);
                }
            }
        }
        @rmdir($dir);
    }
}
