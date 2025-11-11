<!-- Modern Footer Component -->
<footer class="footer-modern">
    <!-- Main Footer Content -->
    <div class="footer-content">
        <div class="container-modern">
            <div class="footer-grid">
                <!-- Company Info -->
                <div class="footer-column">
                    <div class="footer-brand">
                        <img src="{{ asset('logo/RoomLogo.png') }}" alt="RoomMitra Logo" height="60">
                    </div>
                    <p class="footer-description">
                        A one-stop platform for students to find and book verified accommodations with ease and confidence.
                    </p>
                    <!-- Social Links -->
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class='bx bxl-facebook'></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class='bx bxl-twitter'></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class='bx bxl-instagram'></i>
                        </a>
                        <a href="#" class="social-link" aria-label="LinkedIn">
                            <i class='bx bxl-linkedin'></i>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <i class='bx bxl-youtube'></i>
                        </a>
                    </div>
                </div>

                <!-- Explore Links -->
                <div class="footer-column">
                    <h3 class="footer-title">Explore</h3>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ route('home') }}" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('rooms') }}" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>Rooms</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>About Us</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('wishlist.index') }}" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>Wishlist</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div class="footer-column">
                    <h3 class="footer-title">Support</h3>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ route('faqs') }}" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>FAQs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact.form') }}" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>Contact Us</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('complaint.form') }}" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>Complaints</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>Privacy Policy</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="footer-link">
                                <i class='bx bx-chevron-right'></i>
                                <span>Terms & Conditions</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="footer-column">
                    <h3 class="footer-title">Contact Us</h3>
                    <ul class="contact-info">
                        <li class="contact-item">
                            <i class='bx bx-map'></i>
                            <span>Lucknow, Uttar Pradesh, India</span>
                        </li>
                        <li class="contact-item">
                            <i class='bx bx-envelope'></i>
                            <a href="mailto:support@roommitra.com">support@roommitra.com</a>
                        </li>
                        <li class="contact-item">
                            <i class='bx bx-phone'></i>
                            <a href="tel:+919305089318">+91 9305089318</a>
                        </li>
                        <li class="contact-item">
                            <i class='bx bx-time'></i>
                            <span>Mon - Sat: 9:00 AM - 6:00 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container-modern">
            <div class="footer-bottom-content">
                <p class="copyright">
                    © {{ date('Y') }} <span class="gradient-text">RoomMitra</span>. All rights reserved.
                </p>
                <p class="made-with">
                    Made with <i class='bx bx-heart' style="color: #ef4444;"></i> in India
                </p>
            </div>
        </div>
    </div>
</footer>
