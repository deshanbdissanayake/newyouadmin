<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['category', 'author', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $featuredPosts = BlogPost::published()
            ->featured()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->get();

        return view('frontend.blog.index', compact('posts', 'featuredPosts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $post->increment('view_count');

        $relatedPosts = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->take(3)
            ->get();

        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts', 'categories'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $posts = BlogPost::with(['category', 'author', 'tags'])
            ->where('category_id', $category->id)
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->get();

        return view('frontend.blog.category', compact('category', 'posts', 'categories'));
    }

    public function tag($slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()
            ->with(['category', 'author', 'tags'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = BlogCategory::where('is_active', true)
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->get();

        return view('frontend.blog.tag', compact('tag', 'posts', 'categories'));
    }
}