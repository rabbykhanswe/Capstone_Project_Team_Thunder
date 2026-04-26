@extends('layouts.admin')
@section('title','Inquiries')
@section('page-title','Contact Inquiries')
@section('breadcrumb','Inquiries')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-envelope"></i> Contact Inquiries</h1>
        <p>Manage and respond to all customer messages and contact form submissions</p>
    </div>
</div>

<div class="ap-filters">
    @foreach([''=>'All','new'=>'New','read'=>'Read','replied'=>'Replied'] as $val=>$label)
    <a href="{{ route('admin.inquiries.index', $val ? ['status'=>$val] : []) }}"
       class="ap-filter-pill {{ (request('status')??'')===$val ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
</div>

@forelse($inquiries as $inquiry)
<div class="ap-inquiry-card {{ $inquiry->status==='new' ? 'is-new' : '' }}">
    <div class="ap-inquiry-header">
        <div>
            <div class="ap-inquiry-sender">
                <i class="fas fa-user-circle" style="color:var(--ap-green);margin-right:6px;"></i>
                {{ $inquiry->name }}
                @php $is=match($inquiry->status??'new'){'replied'=>'green','read'=>'blue',default=>'yellow'}; @endphp
                <span class="ap-badge ap-badge-{{ $is }}" style="margin-left:8px;">{{ ucfirst($inquiry->status ?? 'new') }}</span>
            </div>
            <div class="ap-inquiry-subject" style="margin-top:4px;">
                <i class="fas fa-envelope" style="color:var(--ap-text-muted);margin-right:6px;"></i>{{ $inquiry->email }}
                @if($inquiry->phone)
                &nbsp;&bull;&nbsp;<i class="fas fa-phone" style="color:var(--ap-text-muted);margin-right:4px;"></i>{{ $inquiry->phone }}
                @endif
            </div>
            @if($inquiry->subject)
            <div style="font-size:14px;font-weight:700;color:var(--ap-text);margin-top:6px;">{{ $inquiry->subject }}</div>
            @endif
        </div>
        <span class="ap-inquiry-meta">{{ $inquiry->created_at->format('d M Y, h:i A') }}</span>
    </div>

    <div class="ap-inquiry-message">{{ $inquiry->message }}</div>

    @if($inquiry->admin_reply)
    <div class="ap-inquiry-reply">
        <strong style="color:var(--ap-green);"><i class="fas fa-reply" style="margin-right:6px;"></i>Your Reply:</strong><br>
        {{ $inquiry->admin_reply }}
    </div>
    @endif

    <div id="reply-form-{{ $inquiry->id }}" style="display:none;">
        <form action="{{ route('admin.inquiries.reply', $inquiry->id) }}" method="POST" class="ap-reply-form">
            @csrf
            <textarea name="admin_reply" rows="3" placeholder="Type your reply...">{{ $inquiry->admin_reply }}</textarea>
            <div style="display:flex;gap:8px;margin-top:8px;">
                <button type="submit" class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-paper-plane"></i> Send Reply</button>
                <button type="button" class="ap-btn ap-btn-gray ap-btn-sm" onclick="document.getElementById('reply-form-{{ $inquiry->id }}').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>

    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:12px;">
        <button class="ap-btn ap-btn-outline ap-btn-sm" onclick="var f=document.getElementById('reply-form-{{ $inquiry->id }}');f.style.display=f.style.display==='none'?'block':'none'">
            <i class="fas fa-reply"></i> {{ $inquiry->admin_reply ? 'Edit Reply' : 'Reply' }}
        </button>
        @if($inquiry->status === 'new')
        <form action="{{ route('admin.inquiries.read', $inquiry->id) }}" method="POST">
            @csrf
            <button class="ap-btn ap-btn-gray ap-btn-sm"><i class="fas fa-eye"></i> Mark Read</button>
        </form>
        @endif
    </div>
</div>
@empty
<div class="ap-card">
    <div class="ap-empty"><i class="fas fa-envelope-open"></i><h3>No inquiries yet</h3><p>Customer contact messages will appear here.</p></div>
</div>
@endforelse

@if(isset($inquiries) && $inquiries->hasPages())
<div class="ap-pagination">{{ $inquiries->links('vendor.pagination.custom-admin') }}</div>
@endif
@endsection
