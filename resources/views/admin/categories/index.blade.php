@extends('layouts.admin')
@section('title','Categories')
@section('page-title','Categories')
@section('breadcrumb','Categories')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-layer-group"></i> Plant Categories</h1>
        <p>Organise your plant catalogue with categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="ap-btn ap-btn-green"><i class="fas fa-plus"></i> Add Category</a>
</div>

<div class="ap-card">
<div class="ap-table-wrap">
<table class="ap-table">
    <thead>
        <tr><th>Name</th><th>Slug</th><th>Plants</th><th>Status</th><th>Description</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td><div class="ap-table-name">{{ ucfirst($category->name) }}</div></td>
            <td><code style="font-size:12px;background:var(--ap-green-50);color:var(--ap-green);padding:2px 8px;border-radius:4px;">{{ $category->slug }}</code></td>
            <td><span class="ap-badge ap-badge-green">{{ $category->products_count ?? 0 }} plants</span></td>
            <td>
                @if($category->is_active)
                    <span class="ap-badge ap-badge-green">Active</span>
                @else
                    <span class="ap-badge" style="background:#fef2f2;color:#dc2626;">Inactive</span>
                @endif
            </td>
            <td style="color:var(--ap-text-muted);font-size:13px;max-width:220px;">{{ Str::limit($category->description,60) }}</td>
            <td>
                <div style="display:flex;gap:6px;">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="ap-btn ap-btn-outline ap-btn-xs"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete category {{ addslashes(ucfirst($category->name)) }}?')">
                        @csrf @method('DELETE')
                        <button class="ap-btn ap-btn-red ap-btn-xs"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">
            <div class="ap-empty"><i class="fas fa-layer-group"></i><h3>No categories yet</h3>
            <p><a href="{{ route('admin.categories.create') }}" class="ap-btn ap-btn-green ap-btn-sm" style="margin-top:12px;"><i class="fas fa-plus"></i> Add First Category</a></p></div>
        </td></tr>
        @endforelse
    </tbody>
</table>
</div>
</div>
@endsection
