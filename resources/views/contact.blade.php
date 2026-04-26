@extends('layouts.app')

@section('title', 'Contact Us - '.($site['site_name'] ?? 'Oronno Plants'))

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-green-700 to-emerald-500 text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <span class="inline-block bg-white bg-opacity-20 text-sm font-semibold px-4 py-1 rounded-full mb-4"><i class="fas fa-envelope mr-1"></i> Get In Touch</span>
        <h1 class="text-5xl font-extrabold mb-4">Contact Us</h1>
        <p class="text-xl text-green-100 max-w-xl mx-auto">Have a question or need help? We'd love to hear from you. Our team responds within 24 hours.</p>
    </div>
</section>

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-100 py-3">
    <div class="container mx-auto px-6">
        <nav class="flex text-sm text-gray-500 gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-green-600 transition-colors"><i class="fas fa-home mr-1"></i>Home</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Contact</span>
        </nav>
    </div>
</div>

{{-- Contact Info + Form --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Contact Info --}}
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Let's Talk</h2>
                    <p class="text-gray-500">Whether it's about an order, plant care, or a partnership — we're here to help.</p>
                </div>

                {{-- Phone --}}
                <div class="flex gap-4 items-start bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone-alt text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 mb-1">Call Us</div>
                        <a href="tel:{{ $site['contact_phone'] ?? '+8801920202157' }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">{{ $site['contact_phone'] ?? '+8801920202157' }}</a>
                    </div>
                </div>

                {{-- WhatsApp --}}
                <div class="flex gap-4 items-start bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 mb-1">WhatsApp</div>
                        <a href="https://wa.me/{{ $site['whatsapp_number'] ?? '8801920202157' }}" target="_blank" class="text-green-600 hover:text-green-700 text-sm font-medium">{{ $site['contact_phone'] ?? '+8801920202157' }}</a>
                    </div>
                </div>

                {{-- Email --}}
                <div class="flex gap-4 items-start bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 mb-1">Email Us</div>
                        <a href="mailto:{{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">{{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}</a>
                    </div>
                </div>

                {{-- Facebook --}}
                <div class="flex gap-4 items-start bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-facebook-f text-blue-700 text-xl"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 mb-1">Facebook</div>
                        <a href="{{ $site['facebook_url'] ?? '#' }}" target="_blank" class="text-blue-700 hover:text-blue-800 text-sm font-medium">{{ $site['facebook_url'] ?? 'facebook.com/oronnoplants' }}</a>
                    </div>
                </div>

                {{-- Location --}}
                <div class="flex gap-4 items-start bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 mb-1">Our Location</div>
                        <div class="text-gray-500 text-sm">{{ $site['contact_address'] ?? 'Dhaka, Bangladesh' }}</div>
                    </div>
                </div>

                {{-- Hours --}}
                <div class="flex gap-4 items-start bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <div class="font-bold text-gray-800 mb-1">Working Hours</div>
                        <div class="text-gray-500 text-sm">{{ $site['business_hours'] ?? 'Sat–Thu: 9AM–8PM | Fri: 2PM–8PM' }}</div>
                    </div>
                </div>

                {{-- Social Links --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <div class="font-bold text-gray-800 mb-3">Follow Us</div>
                    <div class="flex gap-3 flex-wrap">
                        <a href="{{ $site['facebook_url'] ?? '#' }}" target="_blank"
                           class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors" title="Facebook">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="https://wa.me/{{ $site['whatsapp_number'] ?? '8801920202157' }}" target="_blank"
                           class="bg-green-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors" title="WhatsApp">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                        <a href="mailto:{{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}"
                           class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors" title="Email">
                            <i class="fas fa-envelope text-sm"></i>
                        </a>
                        <a href="tel:{{ $site['contact_phone'] ?? '+8801920202157' }}"
                           class="bg-gray-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors" title="Call Us">
                            <i class="fas fa-phone text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-6">Send Us a Message</h2>

                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 flex items-center gap-3">
                    <i class="fas fa-check-circle text-green-500"></i>
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                    @csrf
                    @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
                    </div>
                    @endif
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+880 1712-345678"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="rahim@example.com"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subject *</label>
                        <select name="subject" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800 bg-white">
                            <option value="">Select a subject...</option>
                            <option {{ old('subject')==='Order Inquiry'?'selected':'' }}>Order Inquiry</option>
                            <option {{ old('subject')==='Plant Care Question'?'selected':'' }}>Plant Care Question</option>
                            <option {{ old('subject')==='Delivery Issue'?'selected':'' }}>Delivery Issue</option>
                            <option {{ old('subject')==='Return / Refund'?'selected':'' }}>Return / Refund</option>
                            <option {{ old('subject')==='Partnership / Wholesale'?'selected':'' }}>Partnership / Wholesale</option>
                            <option {{ old('subject')==='Other'?'selected':'' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                        <textarea name="message" rows="5" placeholder="Tell us how we can help you..." required
                                  class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100 transition-all text-gray-800 resize-none">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl transition-colors shadow-md flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6 max-w-3xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Frequently Asked Questions</h2>
            <p class="text-gray-500">Quick answers to common questions.</p>
        </div>
        <div class="space-y-4" id="faq-list">
            @foreach([
                ['How long does delivery take?','We deliver within 2-3 business days in Dhaka and 3-5 business days outside Dhaka.'],
                ['What is your return policy?','We offer a 7-day health guarantee. If your plant arrives damaged, we\'ll replace it or issue a full refund.'],
                ['Do you offer care instructions?','Yes! Every order includes a detailed care guide, and our team is always available to answer questions.'],
                ['Can I order in bulk for events?','Absolutely! Contact us for wholesale or event pricing. We offer special rates for large orders.'],
            ] as $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden faq-item">
                <button class="w-full text-left px-6 py-4 font-semibold text-gray-800 flex justify-between items-center hover:bg-gray-50 transition-colors faq-toggle">
                    {{ $faq[0] }}
                    <i class="fas fa-chevron-down text-green-500 transition-transform duration-200"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-4 text-gray-500">{{ $faq[1] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // FAQ toggle
    document.querySelectorAll('.faq-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            const isOpen = !answer.classList.contains('hidden');
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.add('hidden'));
            document.querySelectorAll('.faq-toggle i').forEach(i => i.style.transform = 'rotate(0deg)');
            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

});
</script>
@endpush
