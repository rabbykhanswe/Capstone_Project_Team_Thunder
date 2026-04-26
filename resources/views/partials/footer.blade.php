<footer class="site-footer">
    <div class="footer-top">
        <div class="footer-grid">

            <!-- Brand + Social -->
            <div class="footer-brand-col">
                <a href="{{ route('home') }}" class="footer-logo-link">
                    <div class="footer-logo-icon"><i class="fas fa-leaf"></i></div>
                    <span class="footer-logo-text">{{ $site['site_name'] ?? 'Oronno Plants' }}</span>
                </a>
                <p class="footer-tagline">{{ $site['site_tagline'] ?? "Bangladesh's trusted digital nursery for plants and gardening." }}</p>
                <div class="footer-social-row">
                    <a href="{{ $site['facebook_url'] ?? '#' }}" target="_blank" class="footer-social-btn fb" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://wa.me/{{ $site['whatsapp_number'] ?? '8801920202157' }}" target="_blank" class="footer-social-btn wa" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:{{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}" class="footer-social-btn mail" title="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="tel:{{ $site['contact_phone'] ?? '+8801920202157' }}" class="footer-social-btn phone" title="Call Us">
                        <i class="fas fa-phone"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="{{ route('products') }}"><i class="fas fa-chevron-right"></i> Shop Plants</a></li>
                    <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    <li><a href="{{ route('cart') }}"><i class="fas fa-chevron-right"></i> Shopping Cart</a></li>
                    <li><a href="{{ route('wishlist') }}"><i class="fas fa-chevron-right"></i> Wishlist</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-col">
                <h4 class="footer-heading">Contact Us</h4>
                <ul class="footer-contact-list">
                    <li>
                        <span class="fc-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <span>{{ $site['contact_address'] ?? 'Dhaka, Bangladesh' }}</span>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fas fa-phone-alt"></i></span>
                        <a href="tel:{{ $site['contact_phone'] ?? '+8801920202157' }}">{{ $site['contact_phone'] ?? '+8801920202157' }}</a>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fab fa-whatsapp"></i></span>
                        <a href="https://wa.me/{{ $site['whatsapp_number'] ?? '8801920202157' }}" target="_blank">{{ $site['contact_phone'] ?? '+8801920202157' }}</a>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fas fa-envelope"></i></span>
                        <a href="mailto:{{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}">{{ $site['contact_email'] ?? 'oronnoplants@gmail.com' }}</a>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fab fa-facebook-f"></i></span>
                        <a href="{{ $site['facebook_url'] ?? '#' }}" target="_blank">{{ $site['facebook_url'] ?? 'facebook.com/oronnoplants' }}</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter + Hours -->
            <div class="footer-col">
                <h4 class="footer-heading">Newsletter</h4>
                <p class="footer-newsletter-text">Subscribe for plant care tips, seasonal offers, and exclusive deals.</p>
                <div class="footer-newsletter-form">
                    <input type="email" placeholder="Enter your email">
                    <button type="button"><i class="fas fa-paper-plane"></i></button>
                </div>
                <div class="footer-hours">
                    <div class="footer-hours-title"><i class="fas fa-clock"></i> Business Hours</div>
                    <div>{{ $site['business_hours'] ?? 'Sat–Thu: 9AM–8PM | Fri: 2PM–8PM' }}</div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Bottom Bar -->
    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p>&copy; {{ date('Y') }} {{ $site['site_name'] ?? 'Oronno Plants' }}. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="{{ route('contact') }}">Privacy Policy</a>
                <span>&middot;</span>
                <a href="{{ route('contact') }}">Terms of Service</a>
                <span>&middot;</span>
                <a href="{{ route('contact') }}">Support</a>
            </div>
        </div>
    </div>
</footer>
