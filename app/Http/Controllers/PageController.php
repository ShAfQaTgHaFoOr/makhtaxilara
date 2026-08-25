<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Page;
use App\Models\Post;
use App\Models\RoutePackage;
use App\Models\TourPackage;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $vehicles = Vehicle::where('is_active', true)->orderBy('sort_order')->get();
        $routes = RoutePackage::where('is_active', true)->orderBy('sort_order')->get();
        $packages = TourPackage::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.home', compact('vehicles', 'routes', 'packages'));
    }

    public function fleet()
    {
        $vehicles = Vehicle::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.fleet', compact('vehicles'));
    }

    public function vehicle(Vehicle $vehicle)
    {
        abort_unless($vehicle->is_active, 404);

        $others = Vehicle::where('is_active', true)
            ->whereKeyNot($vehicle->id)
            ->orderBy('sort_order')->take(3)->get();

        return view('pages.vehicle', compact('vehicle', 'others'));
    }

    public function page(string $slug)
    {
        $page = Page::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('pages.page', compact('page'));
    }

    public function blog()
    {
        $posts = Post::where('is_published', true)->orderByDesc('published_at')->paginate(9);

        return view('pages.blog', compact('posts'));
    }

    public function post(Post $post)
    {
        abort_unless($post->is_published, 404);

        return view('pages.post', compact('post'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:160'],
            'phone'   => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $data['source'] = 'contact';
        Contact::create($data);

        return back()->with('status', 'Thank you! Your message has been sent.');
    }
}
