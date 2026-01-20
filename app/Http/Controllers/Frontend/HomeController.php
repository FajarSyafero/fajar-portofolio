<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\TyperTitle;
use App\Models\Service;
use App\Models\About;
use App\Models\Category;
use App\Models\Experience;
use App\Models\Feedback;
use App\Models\FeedbackSectionSetting;
use App\Models\PortfolioItem;
use App\Models\PortfolioSectionSetting;
use App\Models\SkillItem;
use App\Models\SkillSectionSetting;
use App\Models\Blog;
use App\Models\BlogSectionSetting;
use App\Models\ContactSectionSetting;

class HomeController extends Controller
{
    public function index()
    {
        $hero = Hero::first();
        $typerTitles = TyperTitle::all();
        $services = Service::all();
        $about = About::first(); // Tambahkan ini untuk mengambil data About
        $portfolioTitle = PortfolioSectionSetting::first(); // Tambahkan ini untuk mengambil data Portfolio Section Setting
        $portfolioCategories = Category::all(); // Inisialisasi variabel untuk kategori portfolio jika diperlukan
        $portfolioItems = PortfolioItem::all(); // Inisialisasi variabel untuk item portfolio jika diperlukan
        $skill = SkillSectionSetting::first(); // Decode skills JSON
        $skillItems = SkillItem::all();
        $experience = Experience::first(); // Inisialisasi variabel untuk item pengalaman jika diperlukan
        $feedbacks = Feedback::all(); // Inisialisasi variabel untuk item feedback jika diperlukan
        $feedbackTitle = FeedbackSectionSetting::first(); // Inisialisasi variabel untuk section feedback jika diperlukan
        $blogs = Blog::latest()->take(5)->get(); // Inisialisasi variabel untuk item blog jika diperlukan
        $blogTitle = BlogSectionSetting::first(); // Inisialisasi variabel untuk blog section setting jika diperlukan
        $contactTitle = ContactSectionSetting::first(); // Inisialisasi variabel untuk contact section setting jika diperlukan
        return view('frontend.home', compact('hero', 'typerTitles', 'services', 'about', 'portfolioTitle', 'portfolioCategories', 'portfolioItems', 'skill', 'skillItems', 'experience', 'feedbacks', 'feedbackTitle', 'blogs', 'blogTitle', 'contactTitle'));
    }

    public function showPortfolio($id)
    {
        $portfolio = PortfolioItem::findOrFail($id);
        return view('frontend.portfolio-details', compact('portfolio'));
    }

    public function showBlog($id)
    {
        $blog = Blog::findOrFail($id);
        $previousPost = Blog::where('id', '<', $blog->id)->orderBy('id', 'desc')->first();
        $nextPost = Blog::where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        return view('frontend.blog-details', compact('blog', 'previousPost', 'nextPost'));
    }

    public function blog()
    {
        $blogs = Blog::latest()->paginate(9);
        return view('frontend.blog', compact('blogs'));
    }

    public function contact(Request $request)
    {
       $request->validate([
            'name' => ['required', 'max:200'],
            'subject' => ['required', 'max:300'],
            'email' => ['required', 'email'],
            'message' => ['required', 'max:2000'],
       ]);

    }
}
