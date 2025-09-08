@extends('Layout.Layout')

@section('title')
    Danh sách sản phẩm
@endsection

@section('content_admin')

    @if (session('success'))
        <div class="alert alert-success text-center mt-5">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-5 ">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-center mt-5 mb-3">Danh sách sản phẩm</h1>

    <a href="{{ route('products.create') }}" class="btn btn-outline-success mb-4"
        style="font-size: 1.1em; padding: 10px 20px;">Thêm mới sản phẩm</a>

    <div class="d-flex gap-3 mb-4">
        <!-- Price Order Filter -->
        <form style="width: 200px;" method="GET" action="{{ route('products.index') }}">
            <select style="padding: 10px;" name="price_order" class="form-control" onchange="this.form.submit()">
                <option value="">Sắp xếp giá</option>
                <option value="asc" {{ request('price_order') == 'asc' ? 'selected' : '' }}>Giá tăng dần</option>
                <option value="desc" {{ request('price_order') == 'desc' ? 'selected' : '' }}>Giá giảm dần</option>
            </select>
        </form>

        <!-- Status Filter -->
        <form style="width: 200px;" method="GET" action="{{ route('products.index') }}">
            <select style="padding: 10px;" name="is_active" class="form-control" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Ẩn</option>
            </select>
        </form>

        <!-- Price Range Filter -->
        <form style="width: 200px;" method="GET" action="{{ route('products.index') }}">
            <select style="padding: 10px;" name="price_range" class="form-control" onchange="this.form.submit()">
                <option value="">Chọn mức giá</option>
                <option value="under_200k" {{ request('price_range') == 'under_200k' ? 'selected' : '' }}>Dưới 200k</option>
                <option value="200k_500k" {{ request('price_range') == '200k_500k' ? 'selected' : '' }}>200k - 500k</option>
                <option value="over_500k" {{ request('price_range') == 'over_500k' ? 'selected' : '' }}>Trên 500k</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
        <style>
            .table-responsive table.table {
                min-width: 1200px;
            }
        </style>
            <thead class="table-dark">
                <tr>
                    <th style="min-width: 50px;">ID</th>
                    <th style="min-width: 80px;">Hình ảnh</th>
                    <th style="min-width: 100px;">Tên sản phẩm</th>
                    <th style="min-width: 140px;">Slug</th>
                    <th style="min-width: 120px;">Danh mục</th>
                    {{-- <th style="min-width: 160px;">Khoảng giá</th> --}}
                    <th style="min-width: 110px;">Tổng tồn kho</th>
                    {{-- <th style="min-width: 90px;">Số biến thể</th> --}}
                    <th style="min-width: 100px;">Trạng thái</th>
                    {{-- <th style="min-width: 90px;">Lượt xem</th> --}}
                    <th style="min-width: 140px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if ($product->img_thumb)
                                <img src="{{ Storage::url($product->img_thumb) }}" alt="{{ $product->name }}"
                                     style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                            @else
                                <span class="text-muted">Chưa có ảnh</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>
                        <td>
                            <code>{{ $product->slug ?? 'Chưa có slug' }}</code>
                        </td>
                        <td>{{ $product->categories->name ?? 'Không có' }}</td>
                        {{-- <td>
                            @if ($product->variants->count() > 0)
                                <span class="badge bg-success">
                                    {{ number_format($product->min_price) }}đ - {{ number_format($product->max_price) }}đ
                                </span>
                            @else
                                <span class="badge bg-warning">Chưa có biến thể</span>
                            @endif
                        </td> --}}
                        <td>
                            <span class="badge bg-info">
                                {{ $product->total_quantity ?? 0 }}
                            </span>
                        </td>
                        {{-- <td>
                            <span class="badge bg-primary">
                                {{ $product->variants->count() }}
                            </span>
                        </td> --}}
                        <td>
                            @if ($product->is_active)
                                <span class="badge bg-success">Hiển thị</span>
                                {{-- <small class="d-block text-muted">(is_active = {{ $product->is_active ? 'true' : 'false' }})</small> --}}
                            @else
                                <span class="badge bg-danger">Ẩn</span>
                                {{-- <small class="d-block text-muted">(is_active = {{ $product->is_active ? 'true' : 'false' }})</small> --}}
                            @endif
                        </td>
                        {{-- <td>{{ $product->view ?? 0 }}</td> --}}
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                <!-- Xem chi tiết -->
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="btn btn-info btn-sm"
                                   data-bs-toggle="tooltip"
                                   title="Xem chi tiết sản phẩm">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>

                                <!-- Toggle trạng thái -->
                                <form method="POST" action="{{ route('products.toggle-status', $product->id) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-secondary btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="{{ $product->is_active ? 'Ẩn sản phẩm' : 'Hiển thị sản phẩm' }}">
                                        @if ($product->is_active)
                                            <i class="fas fa-eye-slash"></i> Ẩn
                                        @else
                                            <i class="fas fa-eye"></i> Hiện
                                        @endif
                                    </button>
                                </form>

                                <!-- Xóa sản phẩm -->
                                <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                      style="display: inline;"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Tất cả biến thể cũng sẽ bị xóa!')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Xóa sản phẩm vĩnh viễn">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                                <style>
                                    /* Đảm bảo các nút thao tác luôn nằm cùng một hàng, không bị lệch khi không có ảnh */
                                    td:last-child .d-flex {
                                        flex-wrap: nowrap !important;
                                        gap: 6px;
                                        justify-content: center;
                                        align-items: center;
                                    }
                                    td:last-child .btn {
                                        min-width: 70px;
                                    }
                                </style>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>

@endsection

@section('scripts')
<script>
    // Auto-submit forms when select changes
    document.querySelectorAll('select[onchange]').forEach(function(select) {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Initialize Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
