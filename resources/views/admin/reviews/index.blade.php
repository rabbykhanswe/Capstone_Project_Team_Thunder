@extends('layouts.admin')
@section('title','Reviews')
@section('page-title','Review Moderation')
@section('breadcrumb','Reviews')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-star"></i> Review Moderation</h1>
        <p>Approve, reject and manage all customer plant reviews</p>
    </div>
</div>

<div class="ap-filters">
    @foreach([''=>'All','pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected'] as $val=>$label)
    <a href="{{ route('admin.reviews.index', $val ? ['status'=>$val] : []) }}"
       class="ap-filter-pill {{ (request('status')??'')===$val ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
</div>

@forelse($reviews as $review)
<div class="ap-review-card">
    <div class="ap-review-avatar">{{ strtoupper(substr($review->user->fname ?? 'U', 0, 1)) }}</div>
    <div class="ap-review-body">
        <div class="ap-review-header">
            <span class="ap-review-name">{{ $review->user->fname ?? 'Unknown' }} {{ $review->user->lname ?? '' }}</span>
            <span class="ap-review-plant"><i class="fas fa-leaf" style="color:var(--ap-green);margin-right:4px;"></i>{{ $review->plant->name ?? 'Deleted Plant' }}</span>
            <div class="ap-review-stars">
                @for($i=1;$i<=5;$i++)<i class="fas fa-star" style="color:{{ $i<=$review->rating?'#f59e0b':'#e5e7eb' }}"></i>@endfor
            </div>
            <span class="ap-review-date">{{ $review->created_at->format('d M Y') }}</span>
            @php $rs=match($review->status??'pending'){'approved'=>'green','rejected'=>'red',default=>'yellow'}; @endphp
            <span class="ap-badge ap-badge-{{ $rs }}">{{ ucfirst($review->status ?? 'pending') }}</span>
        </div>
        <div class="ap-review-comment">{{ $review->comment }}</div>
        <div class="ap-review-actions">
            @if(($review->status ?? 'pending') !== 'approved')
            <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                @csrf <input type="hidden" name="status" value="approved">
                <button class="ap-btn ap-btn-green ap-btn-sm"><i class="fas fa-check"></i> Approve</button>
            </form>
            @endif
            @if(($review->status ?? 'pending') !== 'rejected')
            <form action="{{ route('admin.reviews.status', $review->id) }}" method="POST">
                @csrf <input type="hidden" name="status" value="rejected">
                <button class="ap-btn ap-btn-gray ap-btn-sm"><i class="fas fa-times"></i> Reject</button>
            </form>
            @endif
            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                @csrf @method('DELETE')
                <button class="ap-btn ap-btn-red ap-btn-sm"><i class="fas fa-trash"></i> Delete</button>
            </form>
        </div>
    </div>
</div>
@empty
<div class="ap-card">
    <div class="ap-empty"><i class="fas fa-star"></i><h3>No reviews found</h3><p>Customer reviews will appear here.</p></div>
</div>
@endforelse

@if(isset($reviews) && $reviews->hasPages())
<div class="ap-pagination">{{ $reviews->links('vendor.pagination.custom-admin') }}</div>
@endif
@endsection
