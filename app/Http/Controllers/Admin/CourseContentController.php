<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\CourseStory;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Models\CourseQuestion;
use App\Services\CodeExecutionService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CourseContentController extends Controller
{
    protected CodeExecutionService $codeService;

    public function __construct(CodeExecutionService $codeService)
    {
        $this->codeService = $codeService;
    }

    public function index(Course $course)
    {
        $contents = $course->allContents();
        return view('admin.courses.contents.index', compact('course', 'contents'));
    }

    public function create(Course $course)
    {
        $codingRules = CourseQuestion::availableCodingRules();
        return view('admin.courses.contents.create', compact('course', 'codingRules'));
    }

    public function store(Request $request, Course $course)
    {
        Log::info('Course content store request', [
            'request_data' => $request->all(),
            'course_id' => $course->id
        ]);

        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:story,question,coding,video,html',
            'order' => 'required|integer|min:1',
        ];

        // Add conditional validation
        if ($request->type === 'question') {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*'] = 'required|string';
            $rules['correct_answer'] = 'required|string';
        }

        if ($request->type === 'coding') {
            $rules['admin_code'] = 'required|string';
            $rules['starter_code'] = 'nullable|string';
            $rules['expected_output'] = 'required|string';
            $rules['coding_rules'] = 'required|array|min:1';
            $rules['hint'] = 'nullable|string';
            $rules['language'] = 'nullable|string|in:go,javascript,python,java,c,cpp,php,ruby,typescript';
            $rules['test_cases'] = 'nullable|array';
            $rules['test_cases.*.input'] = 'nullable|string';
            $rules['test_cases.*.expected_output'] = 'required_with:test_cases|string';
        }

        if ($request->type === 'video') {
            $rules['video_url'] = 'required|url';
        }

        if ($request->type === 'story') {
            $rules['image_file'] = 'nullable|image|max:10240';
            $rules['audio_file'] = 'nullable|mimes:mp3,wav,ogg,m4a,aac,flac|max:20480';
            $rules['video_url_story'] = 'nullable|url';
        }

        if ($request->type === 'html') {
            $rules['html_code'] = 'nullable|string';
            $rules['css_code'] = 'nullable|string';
            $rules['js_code'] = 'nullable|string';
        }

        $request->validate($rules);

        $data = [
            'course_id' => $course->id,
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order,
        ];

        if ($request->type === 'story') {
            $useImage = $request->boolean('use_image');
            $useAudio = $request->boolean('use_audio');
            $useVideo = $request->boolean('use_video_story');

            $imagePath = null;
            if ($useImage && $request->hasFile('image_file')) {
                $imagePath = $request->file('image_file')->store('stories/images', 'public');
            }

            $audioPath = null;
            if ($useAudio && $request->hasFile('audio_file')) {
                $audioPath = $request->file('audio_file')->store('stories/audios', 'public');
            }

            $videoUrlStory = null;
            if ($useVideo && $request->filled('video_url_story')) {
                $videoUrlStory = $request->video_url_story;
            }

            $data['image_path'] = $imagePath;
            $data['audio_path'] = $audioPath;
            $data['video_url'] = $videoUrlStory;
            $data['use_image'] = $useImage;
            $data['use_audio'] = $useAudio;
            $data['use_video'] = $useVideo;

            $content = CourseStory::create($data);
            Log::info('Course story created', ['story_id' => $content->id]);
        } elseif ($request->type === 'video') {
            $data['video_url'] = $request->video_url;
            $content = CourseVideo::create($data);
            Log::info('Course video created', ['video_id' => $content->id]);
        } elseif ($request->type === 'html') {
            $data['html_code'] = $request->html_code;
            $data['css_code'] = $request->css_code;
            $data['js_code'] = $request->js_code;
            $content = \App\Models\CourseHtml::create($data);
            Log::info('Course html created', ['html_id' => $content->id]);
        } elseif ($request->type === 'coding') {
            // Coding question
            $data['question_type'] = 'coding';
            $data['admin_code'] = $request->admin_code;
            $data['starter_code'] = $request->starter_code;
            $data['expected_output'] = $request->expected_output;
            $data['coding_rules'] = $request->coding_rules;
            $data['test_cases'] = $request->test_cases ? array_values(array_filter($request->test_cases, fn($tc) => !empty($tc['input']) || !empty($tc['expected_output']))) : null;
            $data['hint'] = $request->hint;
            $data['language'] = $request->input('language', 'go');
            $data['options'] = null;
            $data['correct_answer'] = null;
            $content = CourseQuestion::create($data);
            Log::info('Coding question created', ['question_id' => $content->id]);
        } else {
            // Multiple choice question
            $data['question_type'] = 'multiple_choice';
            $data['options'] = $request->options;
            $data['correct_answer'] = $request->correct_answer;
            $content = CourseQuestion::create($data);
            Log::info('Course question created', ['question_id' => $content->id]);
        }

        return redirect()->route('admin.courses.contents.index', $course)
            ->with('success', 'Course content created successfully!');
    }

    public function show(Course $course, $type, $id)
    {
        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
            $content->type = 'story';
        } elseif ($type === 'video') {
            $content = CourseVideo::findOrFail($id);
            $content->type = 'video';
        } elseif ($type === 'html') {
            $content = \App\Models\CourseHtml::findOrFail($id);
            $content->type = 'html';
        } else {
            $content = CourseQuestion::findOrFail($id);
            $content->type = 'question';
        }

        $codingRules = CourseQuestion::availableCodingRules();
        return view('admin.courses.contents.show', compact('course', 'content', 'codingRules'));
    }

    public function edit(Course $course, $type, $id)
    {
        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
            $content->type = 'story';
        } elseif ($type === 'video') {
            $content = CourseVideo::findOrFail($id);
            $content->type = 'video';
        } elseif ($type === 'html') {
            $content = \App\Models\CourseHtml::findOrFail($id);
            $content->type = 'html';
        } else {
            $content = CourseQuestion::findOrFail($id);
            $content->type = 'question';
        }

        $codingRules = CourseQuestion::availableCodingRules();
        return view('admin.courses.contents.edit', compact('course', 'content', 'codingRules'));
    }

    public function update(Request $request, Course $course, $type, $id)
    {
        Log::info('Course content update request', [
            'request_data' => $request->all(),
            'course_id' => $course->id,
            'type' => $type,
            'id' => $id
        ]);

        // Base validation rules
        $rules = [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'order' => 'required|integer|min:1',
        ];

        $isCoding = $request->type === 'coding' || ($type === 'question' && $request->question_type === 'coding');

        if ($request->type === 'question' && !$isCoding) {
            $rules['options'] = 'required|array|min:2';
            $rules['options.*'] = 'required|string';
            $rules['correct_answer'] = 'required|string';
        }

        if ($isCoding) {
            $rules['admin_code'] = 'required|string';
            $rules['starter_code'] = 'nullable|string';
            $rules['expected_output'] = 'required|string';
            $rules['coding_rules'] = 'required|array|min:1';
            $rules['hint'] = 'nullable|string';
            $rules['language'] = 'nullable|string|in:go,javascript,python,java,c,cpp,php,ruby,typescript';
            $rules['test_cases'] = 'nullable|array';
            $rules['test_cases.*.input'] = 'nullable|string';
            $rules['test_cases.*.expected_output'] = 'required_with:test_cases|string';
        }

        if ($type === 'video') {
            $rules['video_url'] = 'required|url';
        }

        if ($type === 'story') {
            $rules['image_file'] = 'nullable|image|max:10240';
            $rules['audio_file'] = 'nullable|mimes:mp3,wav,ogg,m4a,aac,flac|max:20480';
            $rules['video_url_story'] = 'nullable|url';
        }

        if ($type === 'html') {
            $rules['html_code'] = 'nullable|string';
            $rules['css_code'] = 'nullable|string';
            $rules['js_code'] = 'nullable|string';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'order' => $request->order,
        ];

        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);

            $useImage = $request->boolean('use_image');
            $useAudio = $request->boolean('use_audio');
            $useVideo = $request->boolean('use_video_story');

            $imagePath = $content->image_path;
            if ($useImage) {
                if ($request->hasFile('image_file')) {
                    $imagePath = $request->file('image_file')->store('stories/images', 'public');
                }
            } else {
                $imagePath = null;
            }

            $audioPath = $content->audio_path;
            if ($useAudio) {
                if ($request->hasFile('audio_file')) {
                    $audioPath = $request->file('audio_file')->store('stories/audios', 'public');
                }
            } else {
                $audioPath = null;
            }

            $videoUrlStory = $content->video_url;
            if ($useVideo) {
                if ($request->filled('video_url_story')) {
                    $videoUrlStory = $request->video_url_story;
                }
            } else {
                $videoUrlStory = null;
            }

            $data['image_path'] = $imagePath;
            $data['audio_path'] = $audioPath;
            $data['video_url'] = $videoUrlStory;
            $data['use_image'] = $useImage;
            $data['use_audio'] = $useAudio;
            $data['use_video'] = $useVideo;

            $content->update($data);
            Log::info('Course story updated', ['story_id' => $content->id]);
        } elseif ($type === 'video') {
            $content = CourseVideo::findOrFail($id);
            $data['video_url'] = $request->video_url;
            $content->update($data);
            Log::info('Course video updated', ['video_id' => $content->id]);
        } elseif ($type === 'html') {
            $content = \App\Models\CourseHtml::findOrFail($id);
            $data['html_code'] = $request->html_code;
            $data['css_code'] = $request->css_code;
            $data['js_code'] = $request->js_code;
            $content->update($data);
            Log::info('Course html updated', ['html_id' => $content->id]);
        } else {
            $content = CourseQuestion::findOrFail($id);

            if ($isCoding) {
                $data['question_type'] = 'coding';
                $data['admin_code'] = $request->admin_code;
                $data['starter_code'] = $request->starter_code;
                $data['expected_output'] = $request->expected_output;
                $data['coding_rules'] = $request->coding_rules;
                $data['test_cases'] = $request->test_cases ? array_values(array_filter($request->test_cases, fn($tc) => !empty($tc['input']) || !empty($tc['expected_output']))) : null;
                $data['hint'] = $request->hint;
                $data['language'] = $request->input('language', 'go');
            } else {
                $data['question_type'] = 'multiple_choice';
                $data['options'] = $request->options;
                $data['correct_answer'] = $request->correct_answer;
            }

            $content->update($data);
            Log::info('Course question updated', ['question_id' => $content->id]);
        }

        return redirect()->route('admin.courses.contents.index', $course)
            ->with('success', 'Course content updated successfully!');
    }

    public function destroy(Course $course, $type, $id)
    {
        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
        } elseif ($type === 'video') {
            $content = CourseVideo::findOrFail($id);
        } elseif ($type === 'html') {
            $content = \App\Models\CourseHtml::findOrFail($id);
        } else {
            $content = CourseQuestion::findOrFail($id);
        }

        $content->delete();

        return redirect()->route('admin.courses.contents.index', $course)
            ->with('success', 'Course content deleted successfully!');
    }

    /**
     * Admin: compile code to test expected output
     */
    public function compileCode(Request $request)
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
}