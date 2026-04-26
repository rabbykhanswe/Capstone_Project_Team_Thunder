@extends('layouts.admin')
@section('title','Plants')
@section('page-title','Plant Catalogue')
@section('breadcrumb','Plants')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-seedling"></i> Plant Catalogue</h1>
        <p>Manage your plant inventory, prices, and stock levels</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('admin.plants.create') }}" class="ap-btn ap-btn-green"><i class="fas fa-plus"></i> Add Plant</a>
    </div>
</div>

<div class="ap-filters">
    <div class="ap-search-wrap">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.plants.index') }}">
            <input class="ap-search-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search plants...">
        </form>
    </div>
    <span class="ap-badge ap-badge-green" style="margin-left:auto;">{{ $plants->total() ?? count($plants) }} plants</span>
</div>

<div class="ap-card">
<div class="ap-table-wrap">
<table class="ap-table">
    <thead>
        <tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Seasonal</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @forelse($plants as $plant)
        <tr>
            <td>
                @if($plant->image)
                    <img src="{{ asset('images/plants/'.$plant->image) }}" class="ap-table-img">
                @else
                    <div class="ap-table-img-placeholder"><i class="fas fa-leaf"></i></div>
                @endif
            </td>
            <td>
                <div class="ap-table-name">{{ $plant->name }}</div>
                @if($plant->description)
                <div class="ap-table-sub">{{ Str::limit($plant->description,50) }}</div>
                @endif
            </td>
            <td><span class="ap-badge ap-badge-outline">{{ ucfirst($plant->category) }}</span></td>
            <td>
                <form action="{{ route('admin.plants.price', $plant->id) }}" method="POST" style="display:inline-flex;align-items:center;gap:6px;">
                    @csrf
                    <input type="number" name="price" value="{{ $plant->price }}" step="0.01" min="0" class="ap-quick-input">
                    <button type="submit" class="ap-btn ap-btn-green ap-btn-xs" title="Save price"><i class="fas fa-save"></i></button>
                </form>
            </td>
            <td>
                <form action="{{ route('admin.plants.stock', $plant->id) }}" method="POST" style="display:inline-flex;align-items:center;gap:6px;">
                    @csrf
                    <input type="number" name="stock_count" value="{{ $plant->stock_count }}" min="0" class="ap-quick-input">
                    <button type="submit" class="ap-btn ap-btn-green ap-btn-xs" title="Save stock"><i class="fas fa-save"></i></button>
                </form>
                @if($plant->stock_count == 0)
                    <span class="ap-badge ap-badge-red" style="margin-top:4px;display:inline-block;">Out of Stock</span>
                @elseif($plant->stock_count <= 5)
                    <span class="ap-badge ap-badge-yellow" style="margin-top:4px;display:inline-block;">Low</span>
                @endif
            </td>
            <td>
                @if($plant->is_seasonal)
                    <span class="ap-badge ap-badge-purple"><i class="fas fa-sun"></i> {{ ucfirst($plant->season ?? 'Seasonal') }}</span>
                @else
                    <span class="ap-badge ap-badge-gray">Year-round</span>
                @endif
            </td>
            <td>
                <div style="display:flex;gap:6px;">
                    <a href="{{ route('admin.plants.edit', $plant->id) }}" class="ap-btn ap-btn-outline ap-btn-xs"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.plants.destroy', $plant->id) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($plant->name) }}?')">
                        @csrf @method('DELETE')
                        <button class="ap-btn ap-btn-red ap-btn-xs"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="7">
            <div class="ap-empty"><i class="fas fa-seedling"></i><h3>No plants found</h3>
            <p><a href="{{ route('admin.plants.create') }}" class="ap-btn ap-btn-green ap-btn-sm" style="margin-top:12px;"><i class="fas fa-plus"></i> Add Your First Plant</a></p></div>
        </td></tr>
        @endforelse
    </tbody>
</table>
</div>
@if(method_exists($plants,'hasPages') && $plants->hasPages())
<div style="padding:16px 22px;border-top:1px solid var(--ap-border);">{{ $plants->links('vendor.pagination.custom-admin') }}</div>
@endif
</div>
@endsection
