@extends('layouts.admin')
@section('title','Edit Category')
@section('page-title','Edit Category')
@section('breadcrumb','Edit Category')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-edit"></i> Edit Category</h1>
        <p>Update details for <strong>{{ ucfirst($category->name) }}</strong></p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="ap-btn ap-btn-gray"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:600px;">
    <div class="ap-card">
        <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-layer-group"></i> Category Details</div></div>
        <div class="ap-card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="ap-form-group">
                    <label>Category Name <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name',$category->name) }}" class="ap-form-control {{ $errors->has('name')?'error':'' }}" required>
                    @error('name')<div class="ap-form-error">{{ $message }}</div>@enderror
                </div>
                <div class="ap-form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{{ old('slug',$category->slug) }}" class="ap-form-control">
                    <div class="ap-form-hint">Leave blank to auto-generate from the name</div>
                </div>
                <div class="ap-form-group">
                    <label>Description</label>
                    <textarea name="description" class="ap-form-control" rows="3">{{ old('description',$category->description) }}</textarea>
                </div>
                <div class="ap-form-group">
                    <label class="ap-form-check">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <span>Active (visible to customers)</span>
                    </label>
                </div>
                <div class="ap-form-actions">
                    <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="ap-btn ap-btn-gray">Cancel</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="margin-left:auto;" onsubmit="return confirm('Delete this category?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="ap-btn ap-btn-red"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
