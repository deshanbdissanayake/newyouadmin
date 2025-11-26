@extends('frontend.layouts.app')

@section('content')
<div class="blog-post-section py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="blog-post">
                    <!-- Featured Image -->
                    @if($post->featured_image)
                    <div class="post-image mb-4">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded" alt="{{ $post->title }}">
                    </div>
                    @endif

                    <!-- Post Meta -->
                    <div class="post-meta mb-3">
                        <a href="{{ route('blog.category', $post->category->slug) }}" class="badge badge-primary mr-2">
                            {{ $post->category->name }}
                        </a>
                        @if($post->is_featured)
                            <span class="badge badge-warning mr-2">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @endif
                        <span class="text-muted">
                            <i class="far fa-calendar"></i> {{ $post->published_at->format('F d, Y') }}
                        </span>
                        <span class="text-muted ml-3">
                            <i class="far fa-user"></i> {{ $post->author->name }}
                        </span>
                        <span class="text-muted ml-3">
                            <i class="far fa-eye"></i> {{ $post->view_count }} views
                        </span>
                    </div>

                    <!-- Post Title -->
                    <h1 class="post-title mb-4">{{ $post->title }}</h1>

                    <!-- Post Content -->
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                    <div class="post-tags mt-4 pt-4 border-top">
                        <h5 class="mb-3">Tags:</h5>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}" class="badge badge-light badge-lg mr-2 mb-2">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="post-share mt-4 pt-4 border-top">
                        <h5 class="mb-3">Share this post:</h5>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-primary btn-sm mr-2">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-info btn-sm mr-2">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                <div class="related-posts mt-5">
                    <h3 class="mb-4">Related Posts</h3>
                    <div class="row">
                        @foreach($relatedPosts as $related)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}" class="card-img-top" alt="{{ $related->title }}">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('blog.show', $related->slug) }}" class="text-dark">
                                            {{ Str::limit($related->title, 50) }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($related->excerpt, 80) }}
                                    </p>
                                </div>
                                <div class="card-footer bg-white">
                                    <small class="text-muted">
                                        <i class="far fa-calendar"></i> {{ $related->published_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Author Info -->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title">About the Author</h5>
                        <h6 class="mb-0">{{ $post->author->name }}</h6>
                    </div>
                </div>

                <!-- Categories Widget -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-folder"></i> Categories</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @foreach($categories as $category)
                            <li class="mb-2">
                                <a href="{{ route('blog.category', $category->slug) }}" class="text-dark">
                                    {{ $category->name }}
                                    <span class="badge badge-secondary float-right">{{ $category->posts_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Back to Blog -->
                <div class="card">
                    <div class="card-body text-center">
                        <a href="{{ route('blog.index') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-arrow-left"></i> Back to All Posts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.post-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.post-content img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
}

.post-content h2 {
    margin-top: 30px;
    margin-bottom: 15px;
}

.post-content p {
    margin-bottom: 20px;
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}
</style>
@endsection