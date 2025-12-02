<!-- CONTACT SECTION -->
<section id="contact" style="padding: 100px 0; background: linear-gradient(135deg, #FFE5D9 0%, #FFF5EB 100%);">
    <style>
        .contact-container { max-width: 1400px; margin: 0 auto; padding: 0 50px; }
        .contact-header { text-align: center; margin-bottom: 70px; }
        .contact-header h2 { font-size: 3em; color: #333; margin-bottom: 15px; font-weight: 800; }
        .contact-header p { font-size: 1.2em; color: #666; }
        .contact-content { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; }
        .contact-form-section { background: rgba(255, 195, 154, 0.3); padding: 50px; border-radius: 30px; }
        .contact-form-section h3 { font-size: 2em; color: #333; margin-bottom: 30px; font-weight: 700; }
        .form-group { margin-bottom: 25px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 15px 20px; border: 2px solid rgba(255, 140, 66, 0.3);
            border-radius: 15px; font-size: 1em; background: white; font-family: inherit;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #FF8C42; box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
        }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .btn-send {
            width: 100%; padding: 16px; background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white; border: none; border-radius: 50px; font-weight: 700; font-size: 1.1em;
            cursor: pointer; box-shadow: 0 5px 20px rgba(255, 140, 66, 0.4);
        }
        .btn-send:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6); }

        .contact-info-section { display: flex; flex-direction: column; gap: 25px; }
        .contact-method {
            background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            display: flex; align-items: center; gap: 20px; text-decoration: none; color: inherit;
        }
        .contact-method:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(255, 140, 66, 0.2); }

        .contact-icon {
            width: 70px; height: 70px; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
        }

        .contact-details h4 { font-size: 1.3em; color: #333; margin-bottom: 8px; font-weight: 700; }
        .contact-details p { color: #666; font-size: 1.1em; }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .contact-content { grid-template-columns: 1fr; }
            .contact-form-section { padding: 40px 30px; }
        }
        @media (max-width: 768px) {
            .contact-container { padding: 0 20px; }
            .contact-header h2 { font-size: 2.2em; }
            .contact-form-section { padding: 30px 20px; }
        }
    </style>

    <div class="contact-container">
        <div class="contact-header">
            <h2>Get In Touch</h2>
            <p>We'd love to hear from you</p>
        </div>

        <div class="contact-content">
            <!-- FORM -->
            <div class="contact-form-section">
                <h3>Send Us Message</h3>
                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="form-group"><input type="text" name="name" placeholder="Your Name" required></div>
                    <div class="form-group"><input type="email" name="email" placeholder="Your Email" required></div>
                    <div class="form-group"><input type="tel" name="phone" placeholder="Phone Number" required></div>
                    <div class="form-group">
                        <select name="subject" required>
                            <option value="">Select Subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="appointment">Appointment</option>
                            <option value="product">Product Question</option>
                            <option value="feedback">Feedback</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn-send">Send Message</button>
                </form>
            </div>

            <!-- CONTACT INFO -->
            <div class="contact-info-section">
                <a href="mailto:petshoplala@gmail.com" class="contact-method">
                    <div class="contact-icon gmail">
                        <img src="/img/gmail.png" alt="Gmail" style="width: 35px; height: 35px;">
                    </div>
                    <div class="contact-details">
                        <h4>Gmail</h4>
                        <p>petshoplala@gmail.com</p>
                    </div>
                </a>

                <a href="https://instagram.com/petshoplala" class="contact-method" target="_blank">
                    <div class="contact-icon instagram">
                        <img src="/img/ig.png" alt="Instagram" style="width: 35px; height: 35px;">
                    </div>
                    <div class="contact-details">
                        <h4>Instagram</h4>
                        <p>@petshoplala</p>
                    </div>
                </a>

                <a href="https://wa.me/081789445290" class="contact-method" target="_blank">
                    <div class="contact-icon whatsapp">
                        <img src="/img/wa.png" alt="WhatsApp" style="width: 35px; height: 35px;">
                    </div>
                    <div class="contact-details">
                        <h4>WhatsApp</h4>
                        <p>082381182066</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>



<!-- FOOTER (SUDAH DIPISAH) -->
<footer class="footer" style="background: linear-gradient(135deg, #C67B48 0%, #A0613C 100%); color: white; padding: 60px 0 30px;">
    <style>
        .footer-content { max-width: 1400px; margin: 0 auto; padding: 0 50px; display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 50px; margin-bottom: 40px; }
        .footer-about h3 { font-size: 1.8em; margin-bottom: 20px; color: #FFE5D9; }
        .footer-about p { line-height: 1.8; opacity: 0.9; margin-bottom: 15px; }
        .footer-section h4 { font-size: 1.3em; margin-bottom: 20px; color: #FFE5D9; }
        .footer-section ul { list-style: none; }
        .footer-section ul li { margin-bottom: 12px; }
        .footer-section ul li a { color: white; text-decoration: none; opacity: 0.9; }
        .footer-section ul li a:hover { opacity: 1; text-decoration: underline; }
        .footer-bottom { text-align: center; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.2); opacity: 0.8; }

        @media (max-width: 1200px) { .footer-content { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 768px) {
            .footer-content { grid-template-columns: 1fr; gap: 30px; padding: 0 20px; }
        }
    </style>

    <div class="footer-content">
        <div class="footer-about">
            <h3>Petshop Lala</h3>
            <p>Your trusted partner in pet care. Menyediakan grooming dan makanan hewan berkualitas.</p>
            <p><strong>Jl. Perjuangan No.9 Setia Budi, Medan</strong></p>
            <p><strong>📞 082381182066</strong></p>
            <p><strong>✉️ info@petshoplala.com</strong></p>
            <p><strong>🕒 Mon-Sun: 08:00 - 20:00</strong></p>
        </div>

        <div class="footer-section">
            <h4>Services</h4>
            <ul>
                <li><a href="#">Pet Grooming</a></li>
                <li><a href="#">Appointment Booking</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Customer Service</h4>
            <ul>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Refund Policy</a></li>
                <li><a href="#">Payment Methods</a></li>
                <li><a href="#">Terms & Conditions</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h4>Follow Us</h4>
            <p>Instagram: @petshoplala</p>
            <p>Facebook: Petshop Lala</p>
            <p>TikTok: @petshoplala</p>
            <p>WhatsApp Business</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2025 Petshop Lala. All rights reserved. | Trusted, happy pet owners</p>
    </div>
</footer>
