@extends('Layout.Layout')

@section('title')
    Cập nhật sản phẩm - {{ $product->name }}
@endsection

@section('content_admin')

    @if (session('success'))
        <div class="alert alert-success text-center mt-5">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-5">
            {{ session('error') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <div>
            <h1>Cập nhật sản phẩm</h1>
            <h5 class="text-muted">{{ $product->name }}</h5>
        </div>
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="{{ route('product-variants.index', $product->id) }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Quản lý biến thể
            </a>
        </div>
    </div>

    <!-- Alert about variants -->
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle"></i>
        <strong>Lưu ý:</strong> Để thay đổi giá và số lượng, hãy sử dụng
        <a href="{{ route('product-variants.index', $product->id) }}" class="alert-link">quản lý biến thể</a>.
    </div>

    <div class="row">
        <!-- Form -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Thông tin cơ bản</h5>
                </div>
                <div class="card-body">
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
        </div>

        <div class="mb-3">
                            <label for="img_thumb" class="form-label">Ảnh đại diện</label>
                            <input type="file" name="img_thumb" id="img_thumb" class="form-control"
                                   accept="image/*" onchange="previewImage()">
                            @error('img_thumb')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            @if ($product->img_thumb)
                                <div class="mt-2" id="currentImageContainer">
                                    <label class="form-label">Ảnh hiện tại:</label>
                                    <div>
                                        <img src="{{ Storage::url($product->img_thumb) }}" alt="Current Image"
                                             id="currentImage" class="rounded"
                                             style="width: 150px; height: 100px; object-fit: cover;">
                                    </div>
                </div>
            @endif

                            <div id="imagePreviewContainer" style="display: none;">
                                <label class="form-label mt-2">Ảnh mới được chọn:</label>
                                <div>
                                    <img id="imagePreview" src="" alt="Selected Image"
                                         class="rounded" style="width: 150px; height: 100px; object-fit: cover;">
                                </div>
                            </div>
        </div>

        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Chọn danh mục</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                    @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
        </div>

        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" rows="5"
                                      placeholder="Mô tả sản phẩm...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
        </div>

        <div class="mb-3">
                            <label for="images" class="form-label">Thêm ảnh gallery mới</label>
                            <input type="file" id="image-input" name="images[]" multiple class="form-control" accept="image/*">
                            <div id="image-preview-container" class="mt-2"></div>
                            <small class="text-muted">Chọn nhiều ảnh để thêm vào gallery</small>
                            @error('images.*')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
        </div>

        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                       value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Hiển thị sản phẩm</label>
                            </div>
                            @error('is_active')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật sản phẩm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Info & Gallery -->
        <div class="col-md-4">
            <!-- Product Stats -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Thống kê sản phẩm</h6>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="text-primary mb-1">{{ $product->variants->count() }}</h5>
                            <small class="text-muted">Biến thể</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-success mb-1">{{ $product->total_quantity ?? 0 }}</h5>
                            <small class="text-muted">Tổng tồn kho</small>
                        </div>
                    </div>
                    @if ($product->variants->count() > 0)
                        <div class="mt-2">
                            <span class="badge bg-info">{{ number_format($product->min_price) }}đ - {{ number_format($product->max_price) }}đ</span>
                            <br><small class="text-muted">Khoảng giá</small>
                        </div>
                    @endif
                </div>
        </div>

            <!-- Gallery Management -->
            @if ($product->galleries->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Gallery hiện tại ({{ $product->galleries->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($product->galleries as $gallery)
                                <div class="col-6 mb-3">
                                    <div class="position-relative">
                                        <img src="{{ $gallery->image_path }}" alt="Gallery Image"
                                             class="img-fluid rounded"
                                             style="width: 100%; height: 80px; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute delete-gallery-btn"
                                                style="top: 5px; right: 5px; font-size: 10px; padding: 2px 5px;"
                                                data-gallery-id="{{ $gallery->id }}"
                                                data-product-id="{{ $product->id }}">
                                            Xóa
                                        </button>
                                    </div>
                                </div>
            @endforeach
        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Chọn "Xóa" trên ảnh để xóa khỏi gallery
                        </small>
                    </div>
                </div>
            @endif
        </div>
        </div>

    <script>
        // Preview main image
        function previewImage() {
            const fileInput = document.getElementById('img_thumb');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const currentImageContainer = document.getElementById('currentImageContainer');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                    if (currentImageContainer) {
                        currentImageContainer.style.opacity = '0.5';
                    }
                };
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                imagePreviewContainer.style.display = 'none';
                if (currentImageContainer) {
                    currentImageContainer.style.opacity = '1';
                }
            }
        }

        // Preview multiple gallery images
        document.getElementById('image-input').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image-preview-container');

            previewContainer.innerHTML = '';

            if (files.length > 0) {
                const title = document.createElement('div');
                title.innerHTML = `<strong>Ảnh mới sẽ thêm (${files.length}):</strong>`;
                title.className = 'mb-2';
                previewContainer.appendChild(title);

                const imageContainer = document.createElement('div');
                imageContainer.className = 'row';

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-6 mb-2';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                        img.className = 'img-fluid rounded';
                        img.style.width = '100%';
                        img.style.height = '60px';
                        img.style.objectFit = 'cover';

                        col.appendChild(img);
                        imageContainer.appendChild(col);
                };

                reader.readAsDataURL(file);
                }

                previewContainer.appendChild(imageContainer);
            }
        });

        // Handle delete gallery image
        document.querySelectorAll('.delete-gallery-btn').forEach(button => {
            button.addEventListener('click', function() {
                const galleryId = this.dataset.galleryId;
                const productId = this.dataset.productId;

                if (confirm('Bạn có chắc chắn muốn xóa ảnh này không?')) {
                    fetch(`/products/${productId}/galleries/${galleryId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.closest('.col-6').remove(); // Remove the image from DOM
                            alert(data.message);
                        } else {
                            alert('Lỗi: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Đã xảy ra lỗi khi xóa ảnh.');
                    });
                }
            });
        });
    </script>

@endsection
