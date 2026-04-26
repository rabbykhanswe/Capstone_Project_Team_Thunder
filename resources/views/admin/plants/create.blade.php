@extends('layouts.admin')
@section('title','Add Plant')
@section('page-title','Add New Plant')
@section('breadcrumb','Add Plant')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-plus-circle"></i> Add New Plant</h1>
        <p>Fill in the details to add a new plant to your catalogue</p>
    </div>
    <a href="{{ route('admin.plants.index') }}" class="ap-btn ap-btn-gray"><i class="fas fa-arrow-left"></i> Back to Plants</a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:22px;align-items:start;">
    <div>
        <form action="{{ route('admin.plants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="ap-card" style="margin-bottom:20px;">
                <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-info-circle"></i> Basic Information</div></div>
                <div class="ap-card-body">
                    <div class="ap-form-group">
                        <label>Plant Name <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="ap-form-control {{ $errors->has('name')?'error':'' }}" placeholder="e.g. Snake Plant" required>
                        @error('name')<div class="ap-form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="ap-form-group">
                        <label>Description</label>
                        <textarea name="description" class="ap-form-control" rows="4" placeholder="Describe the plant...">{{ old('description') }}</textarea>
                    </div>

                    <div class="ap-form-grid">
                        <div class="ap-form-group">
                            <label>Category <span class="req">*</span></label>
                            <select name="category" class="ap-form-control {{ $errors->has('category')?'error':'' }}" required>
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->name }}" {{ old('category')==$cat->name?'selected':'' }}>{{ ucfirst($cat->name) }}</option>
                                @endforeach
                            </select>
                            @error('category')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="ap-form-group">
                            <label>Price ({{ $site['currency_symbol'] ?? '৳' }}) <span class="req">*</span></label>
                            <input type="number" name="price" value="{{ old('price') }}" class="ap-form-control {{ $errors->has('price')?'error':'' }}" step="0.01" min="0" placeholder="0.00" required>
                            @error('price')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="ap-form-grid">
                        <div class="ap-form-group">
                            <label>Environment <span class="req">*</span></label>
                            <select name="environment" class="ap-form-control {{ $errors->has('environment')?'error':'' }}" required>
                                <option value="">Select environment</option>
                                @foreach(['indoor','outdoor','both'] as $env)
                                <option value="{{ $env }}" {{ old('environment')===$env?'selected':'' }}>{{ ucfirst($env) }}</option>
                                @endforeach
                            </select>
                            @error('environment')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="ap-form-group">
                            <label>Plant Type <span class="req">*</span></label>
                            <select name="plant_type" class="ap-form-control {{ $errors->has('plant_type')?'error':'' }}" required>
                                <option value="">Select type</option>
                                @foreach(['plant','succulent','tool','herb','flowering','foliage'] as $pt)
                                <option value="{{ $pt }}" {{ old('plant_type')===$pt?'selected':'' }}>{{ ucfirst($pt) }}</option>
                                @endforeach
                            </select>
                            @error('plant_type')<div class="ap-form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="ap-form-group">
                        <label>Stock Count <span class="req">*</span></label>
                        <input type="number" name="stock_count" value="{{ old('stock_count',0) }}" class="ap-form-control" min="0" required>
                    </div>
                </div>
            </div>

            <div class="ap-card" style="margin-bottom:20px;">
                <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-sun"></i> Seasonal Info</div></div>
                <div class="ap-card-body">
                    <div class="ap-form-group">
                        <label class="ap-form-check">
                            <input type="checkbox" name="is_seasonal" value="1" id="isSeasonalChk" {{ old('is_seasonal')?'checked':'' }} onchange="document.getElementById('seasonField').style.display=this.checked?'block':'none'">
                            <span>This is a seasonal plant</span>
                        </label>
                    </div>
                    <div id="seasonField" style="display:{{ old('is_seasonal')?'block':'none' }}">
                        <div class="ap-form-group">
                            <label>Season</label>
                            <select name="season" class="ap-form-control">
                                <option value="">Select season</option>
                                @foreach(['spring','summer','autumn','winter','monsoon'] as $s)
                                <option value="{{ $s }}" {{ old('season')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ap-form-group">
                <label>Plant Image</label>
                <input type="file" name="image" id="imageInput" class="ap-form-control" accept="image/*"
                    onchange="var r=new FileReader();r.onload=function(e){var p=document.getElementById('imgPreview');p.src=e.target.result;p.style.display='block';document.getElementById('imgPlaceholder').style.display='none';};r.readAsDataURL(this.files[0])">
                @error('image')<div class="ap-form-error">{{ $message }}</div>@enderror
            </div>
            <div class="ap-form-actions">
                <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Save Plant</button>
                <a href="{{ route('admin.plants.index') }}" class="ap-btn ap-btn-gray">Cancel</a>
            </div>
        </form>
    </div>

    <div class="ap-card">
        <div class="ap-card-header"><div class="ap-card-title"><i class="fas fa-image"></i> Image Preview</div></div>
        <div class="ap-card-body">
            <div style="border:2px dashed var(--ap-border);border-radius:10px;padding:24px;text-align:center;cursor:pointer;" onclick="document.getElementById('imageInput').click()">
                <img id="imgPreview" src="" style="display:none;max-width:100%;border-radius:8px;margin-bottom:8px;">
                <div id="imgPlaceholder">
                    <i class="fas fa-cloud-upload-alt" style="font-size:32px;color:var(--ap-green-200);margin-bottom:8px;display:block;"></i>
                    <div style="font-size:13px;color:var(--ap-text-muted);">Click to browse</div>
                    <div style="font-size:11px;color:var(--ap-text-light);margin-top:4px;">or use the file input above</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
