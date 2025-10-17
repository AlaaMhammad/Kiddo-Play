<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Lesson;

class HomeController extends Controller
{
    // الصفحة الرئيسية
    public function index()
    {
        $featuredGames = Game::where('is_active', true)->take(3)->get();
        $sampleLessons = Lesson::where('is_published', true)->take(3)->get();
        return view('guest.home', compact('featuredGames', 'sampleLessons'));
    }

    // صفحة من نحن
    public function about()
    {
        return view('guest.about');
    }

    // صفحة التواصل
    public function contact()
    {
        return view('guest.contact');
    }

    // معاينة الألعاب العامة
    public function gamePreview()
    {
        $games = Game::where('is_active', true)->paginate(6);
        return view('guest.games.preview', compact('games'));
    }

    // معاينة الدروس العامة
    public function lessonSample()
    {
        $lessons = Lesson::where('is_published', true)->paginate(6);
        return view('guest.lessons.sample', compact('lessons'));
    }
}
