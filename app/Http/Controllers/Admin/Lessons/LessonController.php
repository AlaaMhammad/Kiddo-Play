<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * عرض قائمة الدروس مع صلاحيات
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            // الأدمن يرى كل الدروس
            $lessons = Lesson::latest()->paginate(10);
        } else {
            // الأب والطفل يرون فقط الدروس المنشورة
            $lessons = Lesson::where('is_published', true)
                ->latest()
                ->paginate(10);
        }

        return view('admin.Lessons.lesson.index', compact('lessons'));
    }

    /**
     * عرض تفاصيل درس معين
     */
    public function show(Lesson $lesson)
    {
        $user = Auth::user();

        if ($user->role->name !== 'admin' && !$lesson->is_published) {
            abort(403, 'You do not have access to this lesson.');
        }

        $content = $lesson->content;

        // فصل المحتوى إلى أسطر
        $lines = preg_split('/\r\n|\r|\n/', $content);

        $iconWidth = 32;
        $visualLines = [];

        // مصفوفة الأيقونات الدائرية
        $icons = [
            'icons/icon1.png',
            'icons/icon2.png',
            'icons/icon3.png',
            'icons/icon4.png',
            'icons/icon5.png',
            'icons/icon6.png',
            'icons/icon7.png',
        ];
        $iconsCount = count($icons);

        foreach ($lines as $index => $line) {
            // اختيار أيقونة السطر الحالي بشكل دائري
            $numberIcon = $icons[$index % $iconsCount];

            preg_match_all('/\d+|\+|\-|\*|=/', $line, $matches);
            $elements = $matches[0];

            $visual = '';
            foreach ($elements as $el) {
                if (is_numeric($el)) {
                    // تكرار أيقونة السطر حسب قيمة الرقم
                    for ($i = 0; $i < intval($el); $i++) {
                        $visual .= '<img src="' . asset($numberIcon) . '" style="width:' . $iconWidth . 'px; margin:2px;">';
                    }
                } else {
                    $visual .= ' ' . $el . ' ';
                }
            }

            $visualLines[] = $visual;
        }

        return view('admin.Lessons.lesson.show', compact('lesson', 'content', 'visualLines'));
    }

    /**
     * إنشاء درس جديد (للأدمن فقط)
     */
    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.Lessons.lesson.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'category' => 'required|in:numbers,letters,animals,arithmetic',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'media_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        Lesson::create($validated);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * تعديل درس (للأدمن فقط)
     */
    public function edit(Lesson $lesson)
    {
        $this->authorizeAdmin();
        return view('admin.Lessons.lesson.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'category' => 'required|in:numbers,letters,animals,arithmetic',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'media_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * حذف درس (للأدمن فقط)
     */
    public function destroy(Lesson $lesson)
    {
        $this->authorizeAdmin();
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * دالة مساعدة لفحص صلاحية الأدمن
     */
    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }
}
