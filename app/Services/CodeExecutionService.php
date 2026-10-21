<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CodeExecutionService
{
    /**
     * Wandbox API - free, supports stdin, multi-language
     */
    private const WANDBOX_API = 'https://wandbox.org/api/compile.json';

    /**
     * Available coding rules with their regex patterns
     */
    private static array $rulePatterns = [
        'for_loop'             => '/\bfor\b/',
        'if_statement'         => '/\bif\b/',
        'switch_statement'     => '/\bswitch\b/',
        'function_declaration' => '/\bfunc\s+\w+|\bfunction\s+\w+|\bdef\s+\w+/',
        'variable_declaration' => '/(\bvar\b|:=|\blet\b|\bconst\b|\bint\s+\w|\bdouble\s+\w)/',
        'array_usage'          => '/(\[\]|\bArray\b|\blist\b|\[\d*\])/',
        'map_usage'            => '/(\bmap\s*\[|\bnew Map\b|\bdict\b|\bObject\.keys\b)/',
        'struct_usage'         => '/(\btype\s+\w+\s+struct\b|\bclass\s+\w+)/',
        'goroutine'            => '/\bgo\s+/',
        'channel'              => '/\b(chan\b|make\s*\(\s*chan)/',
        'pointer'              => '/[*&]\w+/',
        'interface_usage'      => '/(\binterface\s*\{|\binterface\s+\w+)/',
        'error_handling'       => '/(\berror\b|\btry\b|\bcatch\b|\bthrow\b|\bexcept\b)/',
        'fmt_println'          => '/(fmt\.Println|console\.log|print\(|System\.out\.println|echo\s)/',
        'fmt_printf'           => '/(fmt\.Printf|printf|System\.out\.printf)/',
        'fmt_scanf'            => '/(fmt\.Scan|prompt\(|input\(|Scanner|fgets|readline)/',
        'string_manipulation'  => '/(strings\.|\.split\(|\.join\(|\.replace\(|str\.)/',
        'math_operations'      => '/[\+\-\*\/]\s*=|[\+\-\*\/]\s/',
        'loop_while'           => '/\bwhile\b/',
        'dom_manipulation'     => '/(document\.|getElementById|querySelector)/',
        'event_handling'       => '/(addEventListener|onclick|onchange)/',
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
     * Fixes language-specific issues (e.g. Java public class)
     */
    private function preprocessCode(string $code, string $language): string
    {
        if ($language === 'java') {
            // Wandbox compiles to prog.java, so public classes cause an error
            // Strip 'public' from class declarations
            $code = preg_replace('/\bpublic\s+class\b/', 'class', $code);
        }

        return $code;
    }

    /**
     * Compile and run code via Wandbox API
     * Supports stdin natively & multiple languages
     */
    public function compile(string $code, ?string $input = null, string $language = 'go'): array
    {
        try {
            $compiler = self::$compilerMap[$language] ?? self::$compilerMap['go'];

            // Pre-process code (e.g. fix Java public class names)
            $code = $this->preprocessCode($code, $language);

            $payload = [
                'code'     => $code,
                'compiler' => $compiler,
            ];

            // Add stdin if provided
            if ($input !== null && $input !== '') {
                $payload['stdin'] = $input;
            }

            // Special compiler options
            if ($language === 'cpp') {
                $payload['options'] = 'warning,cpp-no-pedantic';
                $payload['compiler-option-raw'] = '-std=c++17';
            }

            Log::info('Code execution request', ['language' => $language, 'compiler' => $compiler]);

            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post(self::WANDBOX_API, $payload);

            if ($response->successful()) {
                $data = $response->json();

                $output = $data['program_output'] ?? '';
                $errors = '';

                // Check for compilation errors
                if (!empty($data['compiler_error'])) {
                    $errors .= $data['compiler_error'];
                }

                // Check for runtime errors
                if (!empty($data['program_error'])) {
                    $errors .= $data['program_error'];
                }

                // Check exit status
                $status = $data['status'] ?? '0';
                if ($status !== '0' && $status !== 0) {
                    if (empty($errors)) {
                        $errors = $data['compiler_message'] ?? $data['program_message'] ?? 'Program exited with error';
                    }
                }

                return [
                    'success' => ($status === '0' || $status === 0) && empty($errors),
                    'output'  => trim($output),
                    'errors'  => trim($errors),
                    'raw'     => $data,
                ];
            }

            // Fallback: if Wandbox fails, try Go Playground for Go code
            if ($language === 'go') {
                return $this->compileGoPlayground($code);
            }

            return [
                'success' => false,
                'output'  => '',
                'errors'  => 'Failed to connect to code execution API. Status: ' . $response->status(),
                'raw'     => null,
            ];
        } catch (\Exception $e) {
            Log::error('Code execution error: ' . $e->getMessage());

            // Fallback to Go Playground for Go
            if ($language === 'go') {
                try {
                    return $this->compileGoPlayground($code);
                } catch (\Exception $e2) {
                    // Both failed
                }
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
     * Fallback: Go Playground API (Go only, no stdin support)
     */
    private function compileGoPlayground(string $code): array
    {
        $response = Http::timeout(30)->asForm()->post('https://go.dev/_/compile', [
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

        return [
            'success' => false,
            'output'  => '',
            'errors'  => 'All code execution APIs unavailable',
            'raw'     => null,
        ];
    }

    /**
     * Validate code against a set of rules
     */
    public function validateRules(string $code, array $rules): array
    {
        $results = [];
        $cleanCode = $this->stripCommentsAndStrings($code);

        foreach ($rules as $rule) {
            if (isset(self::$rulePatterns[$rule])) {
                $results[$rule] = (bool) preg_match(self::$rulePatterns[$rule], $cleanCode);
            } else {
                $results[$rule] = true;
            }
        }

        return $results;
    }

    /**
     * Check if the actual output matches the expected output
     */
    public function checkOutput(string $actualOutput, string $expectedOutput): bool
    {
        $normalize = function (string $text): string {
            $text = str_replace("\r\n", "\n", $text);
            $text = str_replace("\r", "\n", $text);
            $lines = array_map('rtrim', explode("\n", $text));
            while (!empty($lines) && $lines[count($lines) - 1] === '') {
                array_pop($lines);
            }
            return implode("\n", $lines);
        };

        return $normalize($actualOutput) === $normalize($expectedOutput);
    }

    /**
     * Strip comments and string literals from code for rule checking
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
     * Run all test cases against user code
     */
    public function runTestCases(string $code, array $testCases, string $language = 'go'): array
    {
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

        return [
            'test_results' => $results,
            'all_passed'   => $allPassed,
            'total'        => count($results),
            'passed_count' => collect($results)->where('passed', true)->count(),
        ];
    }

    /**
     * Full validation: check rules + run all test cases
     */
    public function fullValidation(string $code, array $rules, string $expectedOutput, array $testCases = [], ?string $input = null, string $language = 'go'): array
    {
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

        return [
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
    }
}
