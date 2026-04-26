<footer class="site-footer">
    <div class="footer-top">
        <div class="footer-grid">

            <!-- Brand + Social -->
            <div class="footer-brand-col">
                <a href="<?php echo e(route('home')); ?>" class="footer-logo-link">
                    <div class="footer-logo-icon"><i class="fas fa-leaf"></i></div>
                    <span class="footer-logo-text"><?php echo e($site['site_name'] ?? 'Oronno Plants'); ?></span>
                </a>
                <p class="footer-tagline"><?php echo e($site['site_tagline'] ?? "Bangladesh's trusted digital nursery for plants and gardening."); ?></p>
                <div class="footer-social-row">
                    <a href="<?php echo e($site['facebook_url'] ?? '#'); ?>" target="_blank" class="footer-social-btn fb" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://wa.me/<?php echo e($site['whatsapp_number'] ?? '8801920202157'); ?>" target="_blank" class="footer-social-btn wa" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:<?php echo e($site['contact_email'] ?? 'oronnoplants@gmail.com'); ?>" class="footer-social-btn mail" title="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="tel:<?php echo e($site['contact_phone'] ?? '+8801920202157'); ?>" class="footer-social-btn phone" title="Call Us">
                        <i class="fas fa-phone"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo e(route('home')); ?>"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="<?php echo e(route('products')); ?>"><i class="fas fa-chevron-right"></i> Shop Plants</a></li>
                    <li><a href="<?php echo e(route('about')); ?>"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    <li><a href="<?php echo e(route('cart')); ?>"><i class="fas fa-chevron-right"></i> Shopping Cart</a></li>
                    <li><a href="<?php echo e(route('wishlist')); ?>"><i class="fas fa-chevron-right"></i> Wishlist</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-col">
                <h4 class="footer-heading">Contact Us</h4>
                <ul class="footer-contact-list">
                    <li>
                        <span class="fc-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <span><?php echo e($site['contact_address'] ?? 'Dhaka, Bangladesh'); ?></span>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fas fa-phone-alt"></i></span>
                        <a href="tel:<?php echo e($site['contact_phone'] ?? '+8801920202157'); ?>"><?php echo e($site['contact_phone'] ?? '+8801920202157'); ?></a>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fab fa-whatsapp"></i></span>
                        <a href="https://wa.me/<?php echo e($site['whatsapp_number'] ?? '8801920202157'); ?>" target="_blank"><?php echo e($site['contact_phone'] ?? '+8801920202157'); ?></a>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fas fa-envelope"></i></span>
                        <a href="mailto:<?php echo e($site['contact_email'] ?? 'oronnoplants@gmail.com'); ?>"><?php echo e($site['contact_email'] ?? 'oronnoplants@gmail.com'); ?></a>
                    </li>
                    <li>
                        <span class="fc-icon"><i class="fab fa-facebook-f"></i></span>
                        <a href="<?php echo e($site['facebook_url'] ?? '#'); ?>" target="_blank"><?php echo e($site['facebook_url'] ?? 'facebook.com/oronnoplants'); ?></a>
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
                    <div><?php echo e($site['business_hours'] ?? 'Sat–Thu: 9AM–8PM | Fri: 2PM–8PM'); ?></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer Bottom Bar -->
    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($site['site_name'] ?? 'Oronno Plants'); ?>. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="<?php echo e(route('contact')); ?>">Privacy Policy</a>
                <span>&middot;</span>
                <a href="<?php echo e(route('contact')); ?>">Terms of Service</a>
                <span>&middot;</span>
                <a href="<?php echo e(route('contact')); ?>">Support</a>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\Users\alone\OneDrive\Desktop\Team Thunder\resources\views/partials/footer.blade.php ENDPATH**/ ?>