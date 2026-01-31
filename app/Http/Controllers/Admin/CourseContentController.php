<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\CourseStory;
use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Models\CourseQuestion;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CourseContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $contents = $course->allContents();
        return view('admin.courses.contents.index', compact('course', 'contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('admin.courses.contents.create', compact('course'));
    }

public function store(Request $request, Course $course)
{
    // Debug: Log the incoming request data
    Log::info('Course content store request', [
        'request_data' => $request->all(),
        'course_id' => $course->id
    ]);

    // Base validation rules
    $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'type' => 'required|in:story,question',
        'order' => 'required|integer|min:1',
    ];

    // Add conditional validation only if type is question
    if ($request->type === 'question') {
        $rules['options'] = 'required|array|min:2';
        $rules['options.*'] = 'required|string';
        $rules['correct_answer'] = 'required|string';
    }

    $request->validate($rules);

    $data = [
        'course_id' => $course->id,
        'title' => $request->title,
        'content' => $request->content,
        'order' => $request->order,
    ];

    if ($request->type === 'story') {
        // Save to course_stories table
        $content = CourseStory::create($data);
        Log::info('Course story created', [
            'story_id' => $content->id,
            'story_data' => $content->toArray()
        ]);
    } else {
        // Save to course_questions table
        $data['options'] = $request->options;
        $data['correct_answer'] = $request->correct_answer;
        $content = CourseQuestion::create($data);
        Log::info('Course question created', [
            'question_id' => $content->id,
            'question_data' => $content->toArray()
        ]);
    }

    return redirect()->route('admin.courses.contents.index', $course)
        ->with('success', 'Course content created successfully!');
}

    /**
     * Display the specified resource.
     */
    public function show(Course $course, $type, $id)
    {
        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
            $content->type = 'story';
        } else {
            $content = CourseQuestion::findOrFail($id);
            $content->type = 'question';
        }
        
        return view('admin.courses.contents.show', compact('course', 'content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, $type, $id)
    {
        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
            $content->type = 'story';
        } else {
            $content = CourseQuestion::findOrFail($id);
            $content->type = 'question';
        }
        
        return view('admin.courses.contents.edit', compact('course', 'content'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, $type, $id)
    {
        // Debug: Log the incoming request data
        Log::info('Course content update request', [
            'request_data' => $request->all(),
            'course_id' => $course->id,
            'type' => $type,
            'id' => $id
        ]);

        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'required|integer|min:1',
        ];

        // Add conditional validation only if type is question
        if ($request->type === 'question') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*'] = 'required|string';
            $rules['correct_answer'] = 'required|string';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order,
        ];

        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
            $content->update($data);
            Log::info('Course story updated', [
                'story_id' => $content->id,
                'story_data' => $content->toArray()
            ]);
        } else {
            $data['options'] = $request->options;
            $data['correct_answer'] = $request->correct_answer;
            $content = CourseQuestion::findOrFail($id);
            $content->update($data);
            Log::info('Course question updated', [
                'question_id' => $content->id,
                'question_data' => $content->toArray()
            ]);
        }

        return redirect()->route('admin.courses.contents.index', $course)
            ->with('success', 'Course content updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, $type, $id)
    {
        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
        } else {
            $content = CourseQuestion::findOrFail($id);
        }
        
        $content->delete();

        return redirect()->route('admin.courses.contents.index', $course)
            ->with('success', 'Course content deleted successfully!');
    }
}