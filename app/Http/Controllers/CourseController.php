<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('creator', 'enrollments')->latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $this->authorize('create', Course::class);
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_free' => 'boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'student_count' => 'nullable|integer|min:0',
            'review_count' => 'nullable|integer|min:0',
            'prerequisites' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'badge' => 'nullable|in:hot,new,free',
            'category' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $validated['image'] = $path;
        }

        // Convert curriculum string (one per line) to JSON array
        if (!empty($validated['curriculum'])) {
            $topics = array_filter(array_map('trim', explode("\n", $validated['curriculum'])));
            $validated['curriculum'] = json_encode($topics);
        }

        $validated['created_by'] = Auth::id();
        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        $course->load('lessons', 'enrollments', 'labs');
        $userEnrolled = false;

        if (Auth::check()) {
            $userEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('courses.show', compact('course', 'userEnrolled'));
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_free' => 'boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|string|max:255',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'student_count' => 'nullable|integer|min:0',
            'review_count' => 'nullable|integer|min:0',
            'prerequisites' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'badge' => 'nullable|in:hot,new,free',
            'category' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $validated['image'] = $path;
        }

        // Convert curriculum string (one per line) to JSON array
        if (!empty($validated['curriculum'])) {
            $topics = array_filter(array_map('trim', explode("\n", $validated['curriculum'])));
            $validated['curriculum'] = json_encode($topics);
        }

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
