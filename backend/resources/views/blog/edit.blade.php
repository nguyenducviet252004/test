@extends('Layout.Layout')

@section('title', 'Sửa Blog')

@section('content_admin')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <h1 class="text-center mt-5 mb-3">Sửa bài viết</h1>
        <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT') <!-- Để Laravel biết đây là phương thức PUT -->

            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $blog->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $blog->title) }}" required>
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Tóm tắt</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $blog->description) }}</textarea>
                @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Mô tả</label>
                <textarea name="content" id="content" class="form-control" required>{{ old('content', $blog->content) }}</textarea>
                @error('content')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Hình ảnh</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($blog->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="Current Image" style="max-width: 200px;">
                    </div>
                @endif
                @error('image')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Trạng thái</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" {{ $blog->is_active == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ $blog->is_active == 0 ? 'selected' : '' }}>Không hoạt động</option>
                </select>
                @error('is_active')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
