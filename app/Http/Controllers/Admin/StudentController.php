<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Services\StudentSpreadsheetExporter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = $this->studentQuery($request)
            ->paginate(20)
            ->withQueryString();

        $baseStudentQuery = User::query()->whereHas('role', fn (Builder $query) => $query->where('name', 'user'));
        $stats = [
            'total' => (clone $baseStudentQuery)->count(),
            'with_courses' => (clone $baseStudentQuery)->whereHas('userCourses')->count(),
            'completed' => (clone $baseStudentQuery)->whereHas('userCourses', fn (Builder $query) => $query->where('is_completed', true))->count(),
            'google' => (clone $baseStudentQuery)->whereNotNull('google_id')->count(),
        ];

        $courses = Course::query()
            ->withCount('userCourses')
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('admin.students.index', compact('students', 'stats', 'courses'));
    }

    public function exportExcel(Request $request, StudentSpreadsheetExporter $exporter)
    {
        $students = $this->studentQuery($request)->get();
        $generatedAt = now('Asia/Jakarta');

        return $exporter->download(
            $students,
            'daftar-siswa-talentgroup-'.$generatedAt->format('Y-m-d').'.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $students = $this->studentQuery($request)->get();
        $generatedAt = now('Asia/Jakarta');
        $selectedCourse = $request->filled('course')
            ? Course::find($request->integer('course'))
            : null;

        return Pdf::loadView('admin.students.pdf', [
            'students' => $students,
            'generatedAt' => $generatedAt,
            'selectedCourse' => $selectedCourse,
            'search' => trim((string) $request->query('search', '')),
            'status' => (string) $request->query('status', ''),
        ])
            ->setPaper('a4', 'landscape')
            ->setOption([
                'defaultFont' => 'DejaVu Sans',
                'isRemoteEnabled' => false,
                'isJavascriptEnabled' => false,
            ])
            ->download('daftar-siswa-talentgroup-'.$generatedAt->format('Y-m-d').'.pdf');
    }

    private function studentQuery(Request $request): Builder
    {
        $search = trim((string) $request->query('search', ''));
        $courseId = $request->filled('course') ? $request->integer('course') : null;
        $status = (string) $request->query('status', '');
        $sort = (string) $request->query('sort', 'latest');

        $query = User::query()
            ->whereHas('role', fn (Builder $roleQuery) => $roleQuery->where('name', 'user'))
            ->with(['userCourses.course:id,title'])
            ->withCount([
                'userCourses as courses_count',
                'userCourses as completed_courses_count' => fn (Builder $courseQuery) => $courseQuery->where('is_completed', true),
            ]);

        if ($search !== '') {
            $query->where(function (Builder $searchQuery) use ($search) {
                $searchQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($courseId) {
            $query->whereHas('userCourses', fn (Builder $courseQuery) => $courseQuery->where('course_id', $courseId));
        }

        if (in_array($status, ['completed', 'learning'], true)) {
            $query->whereHas('userCourses', function (Builder $courseQuery) use ($status, $courseId) {
                if ($courseId) {
                    $courseQuery->where('course_id', $courseId);
                }

                $courseQuery->where('is_completed', $status === 'completed');
            });
        } elseif ($status === 'no_course') {
            $query->whereDoesntHave('userCourses');
        } elseif ($status === 'google') {
            $query->whereNotNull('google_id');
        }

        return match ($sort) {
            'oldest' => $query->orderBy('created_at')->orderBy('id'),
            'name' => $query->orderBy('name')->orderBy('id'),
            default => $query->latest()->orderByDesc('id'),
        };
    }
}
