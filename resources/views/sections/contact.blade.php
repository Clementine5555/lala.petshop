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
            cursor: pointer; box-shadow: 0 5px 20px rgba(255, 140, 66, 0.4); transition: all 0.3s;
        }
        .btn-send:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6); }
        .btn-send:disabled { opacity: 0.6; cursor: not-allowed; }

        .contact-info-section { display: flex; flex-direction: column; gap: 25px; }
        .contact-method {
            background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            display: flex; align-items: center; gap: 20px; text-decoration: none; color: inherit; transition: all 0.3s;
        }
        .contact-method:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(255, 140, 66, 0.2); }

        .contact-icon {
            width: 70px; height: 70px; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
        }

        .contact-details h4 { font-size: 1.3em; color: #333; margin-bottom: 8px; font-weight: 700; }
        .contact-details p { color: #666; font-size: 1.1em; }

        /* Toast Notification */
        .toast {
            position: fixed; bottom: 30px; right: 30px; background: white;
            padding: 16px 24px; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            display: flex; align-items: center; gap: 12px; z-index: 9999;
            transform: translateX(120%); transition: transform 0.4s ease; min-width: 300px;
        }
        .toast.show { transform: translateX(0); }
        .toast.success { border-left: 4px solid #10b981; }
        .toast.error { border-left: 4px solid #ef4444; }
        .toast-icon { width: 24px; height: 24px; flex-shrink: 0; }
        .toast.success .toast-icon { color: #10b981; }
        .toast.error .toast-icon { color: #ef4444; }
        .toast-message { flex: 1; color: #333; font-weight: 500; }
        .toast-close { width: 20px; height: 20px; cursor: pointer; color: #999; transition: color 0.3s; }
        .toast-close:hover { color: #333; }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .contact-content { grid-template-columns: 1fr; }
            .contact-form-section { padding: 40px 30px; }
        }
        @media (max-width: 768px) {
            .contact-container { padding: 0 20px; }
            .contact-header h2 { font-size: 2.2em; }
            .contact-form-section { padding: 30px 20px; }
            .toast { right: 20px; min-width: calc(100% - 40px); }
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
                <form id="contactForm" action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    <div class="form-group"><input type="text" name="name" placeholder="Your Name" required></div>
                    <div class="form-group"><input type="email" name="email" placeholder="Your Email" required></div>
                    <div class="form-group"><input type="tel" name="phone" placeholder="Phone Number (Optional)"></div>
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
                        <img src="/images/gmail.png" alt="Gmail" style="width: 35px; height: 35px;">
                    </div>
                    <div class="contact-details">
                        <h4>Gmail</h4>
                        <p>petshoplala@gmail.com</p>
                    </div>
                </a>

                <a href="https://instagram.com/petshoplala" class="contact-method" target="_blank">
                    <div class="contact-icon instagram">
                        <img src="/images/ig.png" alt="Instagram" style="width: 35px; height: 35px;">
                    </div>
                    <div class="contact-details">
                        <h4>Instagram</h4>
                        <p>@petshoplala</p>
                    </div>
                </a>

                <a href="https://wa.me/6282381182066" class="contact-method" target="_blank">
                    <div class="contact-icon whatsapp">
                        <img src="/images/wa.png" alt="WhatsApp" style="width: 35px; height: 35px;">
                    </div>
                    <div class="contact-details">
                        <h4>WhatsApp</h4>
                        <p>082381182066</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="toast-message" id="toastMessage"></span>
        <svg class="toast-close" onclick="hideToast()" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </div>
</section>

<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Disable button & show loading
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending...';
    
    const formData = new FormData(this);
    
    fetch('{{ route("contact.send") }}', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        redirect: 'manual' // Prevent automatic redirect; we'll handle it manually
    })
    .then(async response => {
        const contentType = response.headers.get('content-type') || '';
        
        // If redirect (3xx), Laravel issued a redirect with flash message
        if ([301, 302, 303, 307, 308].includes(response.status)) {
            // Extract flash message from session (we'll manually fetch redirected page to get flash data)
            // For now, show a generic success message and reload to pick up the flash toast
            showToast('Terima kasih telah menghubungi kami. Pesan Anda telah diterima.', 'success');
            this.reset();
            // Reload to ensure flash message is picked up and rendered
            setTimeout(() => location.reload(), 500);
            return;
        }

        // If response is JSON (AJAX flow)
        let data;
        if (contentType.includes('application/json')) {
            data = await response.json();
        } else {
            // If server returned HTML (unexpected), capture it for debugging
            const text = await response.text();
            throw new Error('Unexpected server response: ' + text.substring(0, 400));
        }

        if (response.ok && data.success) {
            showToast(data.message, 'success');
            this.reset();
        } else {
            showToast(data.message || 'Failed to send message', 'error');
        }
    })
    .catch(error => {
        console.error('Contact form error:', error);
        showToast('Failed to send message. Please try again.', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
}function showToast(message, type = 'success') {
    if (!message) return; // avoid showing empty toast
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;

    toast.classList.remove('success', 'error');
    toast.classList.add(type);

    toast.classList.add('show');

    setTimeout(() => hideToast(), 3000);
}

function hideToast() {
    const toast = document.getElementById('toast');
    toast.classList.remove('show');
}

</script>