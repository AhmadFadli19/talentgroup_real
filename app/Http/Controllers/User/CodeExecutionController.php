<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\CodeExecutionService;
use Illuminate\Http\Request;

class CodeExecutionController extends Controller
{
    protected CodeExecutionService $codeService;

    public function __construct(CodeExecutionService $codeService)
    {
        $this->codeService = $codeService;
    }

    /**
     * Compile and run code, with optional stdin input
     */
    public function compile(Request $request)
    {
        $request->validate([
            'code'     => 'required|string',
            'input'    => 'nullable|string',
            'language' => 'nullable|string',
        ]);

        $result = $this->codeService->compile(
            $request->input('code'),
            $request->input('input'),
            $request->input('language', 'go')
        );

        return response()->json($result);
    }

    /**
     * Validate code against rules
     */
    public function validateRules(Request $request)
    {
        $request->validate([
            'code'  => 'required|string',
            'rules' => 'required|array',
        ]);

        $results = $this->codeService->validateRules(
            $request->input('code'),
            $request->input('rules')
        );

        return response()->json([
            'rules'      => $results,
            'all_passed' => !in_array(false, $results, true),
        ]);
    }

    /**
     * Run test cases against user code
     */
    public function runTests(Request $request)
    {
        $request->validate([
            'code'                         => 'required|string',
            'test_cases'                   => 'required|array',
            'test_cases.*.input'           => 'nullable|string',
            'test_cases.*.expected_output' => 'nullable|string',
            'language'                     => 'nullable|string',
        ]);

        $result = $this->codeService->runTestCases(
            $request->input('code'),
            $request->input('test_cases'),
            $request->input('language', 'go')
        );

        return response()->json($result);
    }

    /**
     * Full check: rules + compile + output + test cases
     */
    public function check(Request $request)
    {
        $request->validate([
            'code'                         => 'required|string',
            'rules'                        => 'nullable|array',
            'expected_output'              => 'nullable|string',
            'test_cases'                   => 'nullable|array',
            'test_cases.*.input'           => 'nullable|string',
            'test_cases.*.expected_output' => 'nullable|string',
            'input'                        => 'nullable|string',
            'language'                     => 'nullable|string',
        ]);

        $result = $this->codeService->fullValidation(
            $request->input('code'),
            $request->input('rules'),
            $request->input('expected_output', ''),
            $request->input('test_cases', []),
            $request->input('input'),
            $request->input('language', 'go')
        );

        return response()->json($result);
    }
}
