@extends('layouts.admin')
@section('title','Settings')
@section('page-title','Site Settings')
@section('breadcrumb','Settings')

@section('content')
<div class="ap-page-header">
    <div class="ap-page-header-left">
        <h1><i class="fas fa-cog"></i> Site Settings</h1>
        <p>Manage global website configuration — changes reflect across the entire site</p>
    </div>
</div>

<div class="ap-settings-grid">

    {{-- General Settings --}}
    <div class="ap-settings-card">
        <div class="ap-settings-card-header">
            <i class="fas fa-store"></i>
            <h3>Store Identity</h3>
        </div>
        <div class="ap-settings-card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf @method('PUT')

                <div class="ap-form-group">
                    <label>Site Name <span class="req">*</span></label>
                    <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="ap-form-control" required>
                    <div class="ap-form-hint">Appears in browser tab, emails, and throughout the site</div>
                </div>
                <div class="ap-form-group">
                    <label>Tagline</label>
                    <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="ap-form-control" placeholder="Your store's brief tagline">
                </div>
                <div class="ap-form-group">
                    <label>About Text</label>
                    <textarea name="about_text" class="ap-form-control" rows="3">{{ $settings['about_text'] ?? '' }}</textarea>
                    <div class="ap-form-hint">Used on About and Contact pages</div>
                </div>
                <div class="ap-form-group">
                    <label>Meta Description</label>
                    <textarea name="meta_description" class="ap-form-control" rows="2">{{ $settings['meta_description'] ?? '' }}</textarea>
                    <div class="ap-form-hint">SEO description shown in search results</div>
                </div>

                <hr style="border:none;border-top:1px solid var(--ap-border);margin:20px 0;">
                <p style="font-size:12px;font-weight:700;color:var(--ap-text-muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:14px;">Contact Info</p>

                <div class="ap-form-group">
                    <label>Contact Email</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="ap-form-control">
                </div>
                <div class="ap-form-group">
                    <label>Contact Phone</label>
                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="ap-form-control" placeholder="+880...">
                </div>
                <div class="ap-form-group">
                    <label>Address</label>
                    <input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}" class="ap-form-control" placeholder="City, Country">
                </div>
                <div class="ap-form-group">
                    <label>Facebook URL</label>
                    <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" class="ap-form-control" placeholder="https://facebook.com/...">
                </div>
                <div class="ap-form-group">
                    <label>WhatsApp Number</label>
                    <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" class="ap-form-control" placeholder="880...">
                    <div class="ap-form-hint">Without + prefix, used for wa.me links</div>
                </div>
                <div class="ap-form-group">
                    <label>Business Hours</label>
                    <input type="text" name="business_hours" value="{{ $settings['business_hours'] ?? '' }}" class="ap-form-control" placeholder="Sat–Thu: 9AM–8PM | Fri: 2PM–8PM">
                </div>

                <hr style="border:none;border-top:1px solid var(--ap-border);margin:20px 0;">
                <p style="font-size:12px;font-weight:700;color:var(--ap-text-muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:14px;">Commerce</p>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                    <div class="ap-form-group">
                        <label>Currency Symbol</label>
                        <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '৳' }}" class="ap-form-control" maxlength="5">
                    </div>
                    <div class="ap-form-group">
                        <label>Shipping Fee</label>
                        <input type="number" name="shipping_fee" value="{{ $settings['shipping_fee'] ?? '60' }}" class="ap-form-control" min="0" step="0.01">
                    </div>
                </div>

                <div class="ap-form-actions">
                    <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Save Settings</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SMS Settings --}}
    <div>
        <div class="ap-settings-card" style="margin-bottom:20px;">
            <div class="ap-settings-card-header">
                <i class="fas fa-sms"></i>
                <h3>SMS / Notification API</h3>
            </div>
            <div class="ap-settings-card-body">
                <form action="{{ route('admin.settings.sms.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="ap-form-group">
                        <label>SMS API Token</label>
                        <input type="text" name="sms_api_token" value="{{ $settings['sms_api_token'] ?? '' }}" class="ap-form-control" placeholder="Your API token">
                        <div class="ap-form-hint">Used for order SMS notifications</div>
                    </div>
                    <div class="ap-form-group">
                        <label>SMS API URL</label>
                        <input type="text" name="sms_api_url" value="{{ $settings['sms_api_url'] ?? '' }}" class="ap-form-control" placeholder="https://api.example.com/sms">
                    </div>
                    <div class="ap-form-actions">
                        <button type="submit" class="ap-btn ap-btn-green"><i class="fas fa-save"></i> Save SMS Settings</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Live Preview --}}
        <div class="ap-settings-card">
            <div class="ap-settings-card-header">
                <i class="fas fa-eye"></i>
                <h3>Live Site Preview</h3>
            </div>
            <div class="ap-settings-card-body">
                <p style="font-size:13px;color:var(--ap-text-muted);margin-bottom:16px;">Your current site configuration at a glance.</p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 12px;background:var(--ap-green-50);border-radius:8px;">
                        <span style="color:var(--ap-text-muted);">Site Name</span>
                        <strong>{{ $settings['site_name'] ?? '—' }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 12px;background:var(--ap-green-50);border-radius:8px;">
                        <span style="color:var(--ap-text-muted);">Email</span>
                        <strong>{{ $settings['contact_email'] ?? '—' }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 12px;background:var(--ap-green-50);border-radius:8px;">
                        <span style="color:var(--ap-text-muted);">Phone</span>
                        <strong>{{ $settings['contact_phone'] ?? '—' }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 12px;background:var(--ap-green-50);border-radius:8px;">
                        <span style="color:var(--ap-text-muted);">Shipping</span>
                        <strong>{{ $settings['currency_symbol'] ?? '৳' }}{{ $settings['shipping_fee'] ?? '60' }}</strong>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 12px;background:var(--ap-green-50);border-radius:8px;">
                        <span style="color:var(--ap-text-muted);">Business Hours</span>
                        <strong style="font-size:11px;text-align:right;max-width:160px;">{{ $settings['business_hours'] ?? '—' }}</strong>
                    </div>
                </div>
                <div style="margin-top:16px;">
                    <a href="{{ route('home') }}" target="_blank" class="ap-btn ap-btn-outline" style="width:100%;justify-content:center;">
                        <i class="fas fa-external-link-alt"></i> View Live Site
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
