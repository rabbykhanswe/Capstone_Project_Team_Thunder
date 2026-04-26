@extends('layouts.admin')
@section('title','Edit Plant')
@section('page-title','Edit Plant')
@section('breadcrumb','Edit Plant')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-edit"></i> Edit Plant</h1>
        <p>Update details for <strong>{{ $plant->name }}</strong></p>
    </div>
    <a href="{{ route('admin.plants.index') }}" class="ap-btn ap-btn-gray"><i class="fas fa-arrow-left"></i> Back to Plants</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;align-items:start;">
    <div>
        <form action="{{ route('admin.plants.update', $plant->id) }}" method="POST" enctype="multipart/form-data" id="plant-edit-form">
            @csrf @method('PUT')

            <div class="ap-card" style="margin-bottom:20px;">
                <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-info-circle"></i> Basic Information</div></div>
                <div class="ap-card-body">
                    <div class="ap-form-group">
                        <label>Plant Name <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name',$plant->name) }}" class="ap-form-control {{ $errors->has('name')?'error':'' }}" required>
                        @error('name')<div class="ap-form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="ap-form-group">
                        <label>Description</label>
                        <textarea name="description" class="ap-form-control" rows="4">{{ old('description',$plant->description) }}</textarea>
                    </div>
                    <div class="ap-form-grid">
                        <div class="ap-form-group">
                            <label>Category <span class="req">*</span></label>
                            <select name="category" class="ap-form-control" required>
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" {{ old('category',$plant->category)===$cat->name?'selected':'' }}>{{ ucfirst($cat->name) }}</option>
                                @endforeach
                            </select>
                            @error('category')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="ap-form-group">
                            <label>Price ({{ $site['currency_symbol'] ?? '৳' }}) <span class="req">*</span></label>
                            <input type="number" name="price" value="{{ old('price',$plant->price) }}" class="ap-form-control" step="0.01" min="0" required>
                            @error('price')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="ap-form-grid">
                        <div class="ap-form-group">
                            <label>Environment <span class="req">*</span></label>
                            <select name="environment" class="ap-form-control" required>
                                <option value="">Select environment</option>
                                @foreach(['indoor','outdoor','both'] as $env)
                                <option value="{{ $env }}" {{ old('environment',$plant->environment)===$env?'selected':'' }}>{{ ucfirst($env) }}</option>
                                @endforeach
                            </select>
                            @error('environment')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="ap-form-group">
                            <label>Plant Type <span class="req">*</span></label>
                            <select name="plant_type" class="ap-form-control" required>
                                <option value="">Select type</option>
                                @foreach(['plant','succulent','tool','herb','flowering','foliage'] as $pt)
                                <option value="{{ $pt }}" {{ old('plant_type',$plant->plant_type)===$pt?'selected':'' }}>{{ ucfirst($pt) }}</option>
                                @endforeach
                            </select>
                            @error('plant_type')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="ap-form-group">
                        <label>Stock Count</label>
                        <input type="number" name="stock_count" value="{{ old('stock_count',$plant->stock_count) }}" class="ap-form-control" min="0">
                    </div>
                </div>
            </div>

            <div class="ap-card" style="margin-bottom:20px;">
                <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-sun"></i> Seasonal Info</div></div>
                <div class="ap-card-body">
                    <div class="ap-form-group">
                        <label class="ap-form-check">
                            <input type="checkbox" name="is_seasonal" value="1" id="isSeasonalChk"
                                {{ old('is_seasonal',$plant->is_seasonal)?'checked':'' }}
                                onchange="document.getElementById('seasonField').style.display=this.checked?'block':'none'">
                            <span>This is a seasonal plant</span>
                        </label>
                    </div>
                    <div id="seasonField" style="display:{{ old('is_seasonal',$plant->is_seasonal)?'block':'none' }}">
                        <div class="ap-form-group">
                            <label>Season</label>
                            <select name="season" class="ap-form-control">
                                <option value="">Select season</option>
                                @foreach(['spring','summer','autumn','winter','monsoon'] as $s)
                                <option value="{{ $s }}" {{ old('season',$plant->season)===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ap-form-actions">
                <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Update Plant</button>
                <a href="{{ route('admin.plants.index') }}" class="ap-btn ap-btn-gray">Cancel</a>
                <button type="button" class="ap-btn ap-btn-red" style="margin-left:auto;" onclick="if(confirm('Delete this plant permanently?')) document.getElementById('plant-delete-form').submit()">
                    <i class="fas fa-trash"></i> Delete Plant
                </button>
            </div>
        </form>

        <form id="plant-delete-form" action="{{ route('admin.plants.destroy', $plant->id) }}" method="POST">
            @csrf @method('DELETE')
        </form>
    </div>

    <div class="ap-card">
        <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-image"></i> Plant Image</div></div>
        <div class="ap-card-body">
            @if($plant->image)
            <img src="{{ asset('images/plants/'.$plant->image) }}" id="imgPreview" style="width:100%;border-radius:10px;object-fit:cover;max-height:200px;margin-bottom:12px;">
            @else
            <img id="imgPreview" src="" style="display:none;width:100%;border-radius:10px;object-fit:cover;max-height:200px;margin-bottom:12px;">
            @endif
            <div class="ap-form-group">
                <label>Replace Image</label>
                <input type="file" name="image" class="ap-form-control" accept="image/*" form="plant-edit-form"
                    onchange="var r=new FileReader();r.onload=function(e){document.getElementById('imgPreview').src=e.target.result;document.getElementById('imgPreview').style.display='block';};r.readAsDataURL(this.files[0])">
                <div class="ap-form-hint">Leave blank to keep current image</div>
                @error('image')<div class="ap-form-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>
@endsection
