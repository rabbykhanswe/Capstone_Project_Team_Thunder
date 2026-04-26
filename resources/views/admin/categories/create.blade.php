@extends('layouts.admin')
@section('title','Add Category')
@section('page-title','Add Category')
@section('breadcrumb','Add Category')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-plus-circle"></i> Add New Category</h1>
        <p>Create a new category to organise your plants</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="ap-btn ap-btn-gray"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:600px;">
    <div class="ap-card">
        <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-layer-group"></i> Category Details</div></div>
        <div class="ap-card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="ap-form-group">
                    <label>Category Name <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="ap-form-control {{ $errors->has('name')?'error':'' }}" placeholder="e.g. Indoor Plants" required>
                    @error('name')<div class="ap-form-error">{{ $message }}</div>@enderror
                </div>
                <div class="ap-form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="ap-form-control" placeholder="auto-generated from name">
                    <div class="ap-form-hint">Leave blank to auto-generate from the name</div>
                    @error('slug')<div class="ap-form-error">{{ $message }}</div>@enderror
                </div>
                <div class="ap-form-group">
                    <label>Description</label>
                    <textarea name="description" class="ap-form-control" rows="3" placeholder="Brief description of this category">{{ old('description') }}</textarea>
                </div>
                <div class="ap-form-group">
                    <label class="ap-form-check">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                        <span>Active (visible to customers)</span>
                    </label>
                </div>
                <div class="ap-form-actions">
                    <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Create Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="ap-btn ap-btn-gray">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
