@extends('frontend.layouts.app')

@section('content')
<div class="blog-tag-section py-5">
    <div class="container">
        <!-- Page Header -->
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 font-weight-bold">
                    <i class="fas fa-tag text-primary"></i> #{{ $tag->name }}
                </h1>
                <p class="text-muted">{{ $posts->total() }} {{ Str::plural('post', $posts->total()) }} with this tag</p>
            </div>
        </div>

        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8">
                @forelse($posts as $post)
                <div class="card mb-4 shadow-sm">
                    <div class="row no-gutters">
                        @if($post->featured_image)
                        <div class="col-md-4">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" class="card-img h-100" alt="{{ $post->title }}">
                        </div>
                        @endif
                        <div class="{{ $post->featured_image ? 'col-md-8' : 'col-12' }}">
                            <div class="card-body">
                                <div class="mb-2">
                                    <a href="{{ route('blog.category', $post->category->slug) }}" class="badge badge-primary">
                                        {{ $post->category->name }}
                                    </a>
                                    @if($post->is_featured)
                                        <span class="badge badge-warning ml-1">
                                            <i class="fas fa-star"></i> Featured
                                        </span>
                                    @endif
                                </div>
                                <h3 class="card-title h4">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="card-text text-muted">{{ Str::limit($post->excerpt, 150) }}</p>
                                
                                <div class="post-meta small text-muted mb-3">
                                    <span><i class="far fa-user"></i> {{ $post->author->name }}</span>
                                    <span class="ml-3"><i class="far fa-calendar"></i> {{ $post->published_at->format('M d, Y') }}</span>
                                    <span class="ml-3"><i class="far fa-eye"></i> {{ $post->view_count }} views</span>
                                </div>

                                @if($post->tags->count() > 0)
                                <div class="mb-2">
                                    @foreach($post->tags->take(5) as $postTag)
                                    <a href="{{ route('blog.tag', $postTag->slug) }}" class="badge badge-light {{ $postTag->id == $tag->id ? 'badge-primary' : '' }}">
                                        #{{ $postTag->name }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif

                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">
                    No posts found with this tag.
                </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories Widget -->
                <div class="card mb-4 shadow-sm">
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
                <div class="card shadow-sm">
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
.card-img {
    height: 200px;
    object-fit: cover;
}
</style>
@endsection