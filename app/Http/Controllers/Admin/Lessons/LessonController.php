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
        $lines = preg_split('/\r\n|\r|\n/', $content);

        $lineIcons = json_decode($lesson->line_icons, true) ?? [];

        // أيقونات الأرقام والعمليات
        $elementIcons = [
            "0" => "icons/0.png",
            "1" => "icons/1.png",
            "2" => "icons/2.png",
            "3" => "icons/3.png",
            "4" => "icons/4.png",
            "5" => "icons/5.png",
            "6" => "icons/6.png",
            "7" => "icons/7.png",
            "8" => "icons/8.png",
            "9" => "icons/9.png",
            "+" => "icons/plus.svg",
            "-" => "icons/minus.svg",
            "*" => "icons/multiply.svg",
            "=" => "icons/equal.svg",
        ];

        $iconWidth = 32;
        $visualLines = [];
        $textAsIcons = [];

        foreach ($lines as $index => $line) {
            $lineIcon = $lineIcons[$index] ?? null;

            preg_match_all('/\d+|\+|\-|\*|=/', $line, $matches);
            $elements = $matches[0];

            $visual = '';
            $converted = '';

            foreach ($elements as $el) {

                // السطر الأول: تكرار أيقونة السطر حسب الرقم
                if (is_numeric($el) && $lineIcon) {
                    for ($i = 0; $i < intval($el); $i++) {
                        $visual .= '<img src="' . asset($lineIcon) . '" style="width:' . $iconWidth . 'px; margin:2px;">';
                    }
                } else {
                    $visual .= '<img src="' . asset($elementIcons[$el]) . '" style="width:' . $iconWidth . 'px; margin:2px;">';
                }

                // السطر الثاني: رقم → صورة واحدة فقط
                if (isset($elementIcons[$el])) {
                    $converted .= '<img src="' . asset($elementIcons[$el]) . '" style="width:' . $iconWidth . 'px; margin:2px;">';
                }
            }

            $visualLines[] = $visual;
            $textAsIcons[] = $converted;
        }

        return view('admin.Lessons.lesson.show', compact('lesson', 'content', 'visualLines', 'textAsIcons'));
    }

    // public function show(Lesson $lesson)
    // {
    //     $user = Auth::user();

    //     if ($user->role->name !== 'admin' && !$lesson->is_published) {
    //         abort(403, 'You do not have access to this lesson.');
    //     }

    //     $content = $lesson->content;
    //     $lines = preg_split('/\r\n|\r|\n/', $content);

    //     $lineIcons = json_decode($lesson->line_icons, true) ?? [];



    //     $iconWidth = 32;
    //     $visualLines = [];

    //     foreach ($lines as $index => $line) {
    //         // أيقونة السطر الحالي
    //         $lineIcon = $lineIcons[$index] ?? null;

    //         preg_match_all('/\d+|\+|\-|\*|=/', $line, $matches);
    //         $elements = $matches[0];

    //         $visual = '';
    //         foreach ($elements as $el) {
    //             if (is_numeric($el) && $lineIcon) {
    //                 // تكرار الأيقونة حسب قيمة الرقم
    //                 for ($i = 0; $i < intval($el); $i++) {
    //                     $visual .= '<img src="' . asset($lineIcon) . '" style="width:' . $iconWidth . 'px; margin:2px;">';
    //                 }
    //             } else {
    //                 // علامات + - * = تبقى كما هي
    //                 $visual .= ' ' . $el . ' ';
    //             }
    //         }

    //         $visualLines[] = $visual;
    //     }

    //     return view('admin.Lessons.lesson.show', compact('lesson', 'content', 'visualLines'));
    // }


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
            'category'     => 'required|in:numbers,letters,animals,arithmetic',
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string',
            'content'      => 'nullable|array',
            'content.*'    => 'nullable|string',
            'line_icons' => 'nullable|array',
            'line_icons.*' => 'nullable|string',
            'media_url'    => 'nullable|string|max:255',
            'order'        => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        // دمج الـ content[] في نص واحد مفصول بسطر جديد
        $validated['content'] = implode("\n", $request->input('content', []));
        $validated['line_icons'] = json_encode($request->input('line_icons', []));

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
            'category'     => 'required|in:numbers,letters,animals,arithmetic',
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string',
            'content'      => 'nullable|array',
            'content.*'    => 'nullable|string',
            'line_icons' => 'nullable|array',
            'line_icons.*' => 'nullable|string',
            'media_url'    => 'nullable|string|max:255',
            'order'        => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        // دمج الـ content[] في نص واحد مفصول بسطر جديد
        $validated['content'] = implode("\n", $request->input('content', []));
        $validated['line_icons'] = json_encode($request->input('line_icons', []));

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
