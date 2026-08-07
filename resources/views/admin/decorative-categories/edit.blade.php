@extends('admin.page')

@section('title', $title)

@section('content_header')
<div class="row">
    <div class="col-12">
        <div class="my-3">
            <h4>{{ $title }}</h4>
            <a href="{{ route('decorative_category_admin') }}" class="btn btn-secondary mt-2">Back to List</a>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('decorative_category_admin.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Name *</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="slug">Slug (Optional - auto generated if empty)</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="parent_id">Parent Category</label>
                            <select name="parent_id" class="form-control">
                                <option value="">None (Main Category)</option>
                                @foreach($parent_categories as $parent)
                                    <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="image">Category Image</label>
                            <input type="file" name="image" class="form-control-file" accept="image/*" onchange="previewImage(this, 'category-image-preview')">
                            <div class="mt-2" id="category-image-preview" style="{{ $category->image ? 'display: block;' : 'display: none;' }}">
                                <img src="{{ $category->image ? asset('uploads/decorative_categories/'.$category->image) : '' }}" style="max-height: 150px; border: 1px solid #ccc; padding: 2px;">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Category</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('extra_js')
<script>
    function previewImage(input, previewId) {
        const previewContainer = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewContainer.querySelector('img').src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            // retain old image view if cancelled
        }
    }
</script>
@stop
