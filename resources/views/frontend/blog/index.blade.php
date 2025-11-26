@extends('admin.layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Blog Posts</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Blog Posts</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Blog Posts</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Create New Post
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="30%">Title</th>
                                        <th width="12%">Category</th>
                                        <th width="10%">Author</th>
                                        <th width="10%">Status</th>
                                        <th width="8%">Featured</th>
                                        <th width="8%">Views</th>
                                        <th width="10%">Published</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($posts as $post)
                                        <tr>
                                            <td>{{ $post->id }}</td>
                                            <td>
                                                <strong>{{ Str::limit($post->title, 50) }}</strong>
                                                @if($post->featured_image)
                                                    <br><small class="text-muted"><i class="fas fa-image"></i> Has image</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $post->category->name }}</span>
                                            </td>
                                            <td>{{ $post->author->name ?? 'N/A' }}</td>
                                            <td>
                                                @if($post->status === 'published')
                                                    <span class="badge badge-success">Published</span>
                                                @elseif($post->status === 'draft')
                                                    <span class="badge badge-secondary">Draft</span>
                                                @else
                                                    <span class="badge badge-warning">Archived</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($post->is_featured)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-muted"></i>
                                                @endif
                                            </td>
                                            <td>{{ $post->view_count }}</td>
                                            <td>
                                                @if($post->published_at)
                                                    {{ $post->published_at->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">Not published</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.blog.posts.edit', $post) }}" class="btn btn-sm btn-info" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.blog.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No blog posts found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection