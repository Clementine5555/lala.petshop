<section id="contact" style="padding: 100px 0; background: linear-gradient(135deg, #FFE5D9 0%, #FFF5EB 100%); position: relative;">

    <style>
        /* Container Styling */
        .contact-container { max-width: 1400px; margin: 0 auto; padding: 0 50px; }
        .contact-header { text-align: center; margin-bottom: 70px; }
        .contact-header h2 { font-size: 3em; color: #333; margin-bottom: 15px; font-weight: 800; }
        .contact-header p { font-size: 1.2em; color: #666; }

        /* Grid Layout */
        .contact-content { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; }

        /* Form Section */
        .contact-form-section { background: rgba(255, 195, 154, 0.3); padding: 50px; border-radius: 30px; }
        .contact-form-section h3 { font-size: 2em; color: #333; margin-bottom: 30px; font-weight: 700; }

        /* Form Elements */
        .form-group { margin-bottom: 25px; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 15px 20px; border: 2px solid rgba(255, 140, 66, 0.3);
            border-radius: 15px; font-size: 1em; background: white; font-family: inherit;
        }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #FF8C42; box-shadow: 0 0 0 3px rgba(255, 140, 66, 0.1);
        }
        .form-group textarea { min-height: 120px; resize: vertical; }

        /* Button */
        .btn-send {
            width: 100%; padding: 16px; background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white; border: none; border-radius: 50px; font-weight: 700; font-size: 1.1em;
            cursor: pointer; box-shadow: 0 5px 20px rgba(255, 140, 66, 0.4); transition: all 0.3s;
        }
        .btn-send:hover { transform: translateY(-3px); box-shadow: 0 8px 30px rgba(255, 140, 66, 0.6); }
        .btn-send:disabled { opacity: 0.7; cursor: wait; }

        /* Contact Info Cards */
        .contact-info-section { display: flex; flex-direction: column; gap: 25px; }
        .contact-method {
            background: white; padding: 30px; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            display: flex; align-items: center; gap: 20px; text-decoration: none; color: inherit; transition: all 0.3s;
        }
        .contact-method:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(255, 140, 66, 0.2); }
        .contact-icon { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .contact-details h4 { font-size: 1.3em; color: #333; margin-bottom: 8px; font-weight: 700; }
        .contact-details p { color: #666; font-size: 1.1em; }

        /* --- TOAST NOTIFICATION KECIL (FIXED) --- */
        .toast-container {
            position: fixed;
            top: 100px; /* Jarak dari atas (biar gak ketutup navbar) */
            right: 20px;
            z-index: 10000; /* Paling depan */
        }

        .toast-notification {
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 350px; /* Batasi lebar agar tidak setengah layar */
            transform: translateX(120%); /* Sembunyi di kanan */
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            opacity: 0;
            border-left: 5px solid #FF8C42;
        }

        .toast-notification.active {
            transform: translateX(0); /* Muncul */
            opacity: 1;
        }

        .toast-notification.success { border-left-color: #28a745; }
        .toast-notification.error { border-left-color: #dc3545; }

        .toast-icon svg { width: 24px; height: 24px; }
        .success .toast-icon { color: #28a745; }
        .error .toast-icon { color: #dc3545; }

        .toast-content h4 { margin: 0; font-size: 14px; font-weight: 800; color: #333; }
        .toast-content p { margin: 2px 0 0; font-size: 13px; color: #666; line-height: 1.4; }

        .toast-close { cursor: pointer; color: #999; margin-left: auto; background: none; border: none; font-size: 18px; }
        .toast-close:hover { color: #333; }

        /* Responsive */
        @media (max-width: 992px) { .contact-content { grid-template-columns: 1fr; } .contact-form-section { padding: 40px 30px; } }
        @media (max-width: 768px) { .contact-container { padding: 0 20px; } .contact-header h2 { font-size: 2.2em; } .contact-form-section { padding: 30px 20px; } .toast-notification { width: 90%; right: 5%; left: 5%; max-width: none; } }
    </style>

    <div class="toast-container">
        <div id="customToast" class="toast-notification">
            <div class="toast-icon" id="toastIcon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="toast-content">
                <h4 id="toastTitle">Berhasil!</h4>
                <p id="toastMessage">Pesan Anda telah terkirim.</p>
            </div>
            <button class="toast-close" onclick="hideToast()">×</button>
        </div>
    </div>

    <div class="contact-container">
        <div class="contact-header">
            <h2>Get In Touch</h2>
            <p>We'd love to hear from you</p>
        </div>

        <div class="contact-content">
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

            <div class="contact-info-section">
                <a href="mailto:petshoplala@gmail.com" class="contact-method">
                    <div class="contact-icon gmail"><img src="/images/gmail.png" alt="Gmail" style="width: 35px;"></div>
                    <div class="contact-details"><h4>Gmail</h4><p>petshoplala@gmail.com</p></div>
                </a>
                <a href="https://instagram.com/petshoplala" class="contact-method" target="_blank">
                    <div class="contact-icon instagram"><img src="/images/ig.png" alt="Instagram" style="width: 35px;"></div>
                    <div class="contact-details"><h4>Instagram</h4><p>@petshoplala</p></div>
                </a>
                <a href="https://wa.me/6282381182066" class="contact-method" target="_blank">
                    <div class="contact-icon whatsapp"><img src="/images/wa.png" alt="WhatsApp" style="width: 35px;"></div>
                    <div class="contact-details"><h4>WhatsApp</h4><p>082381182066</p></div>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // 1. AJAX SUBMIT (Agar tidak reload jika tidak perlu)
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const btn = this.querySelector('.btn-send');
        const originalText = btn.textContent;
        btn.textContent = 'Sending...';
        btn.disabled = true;

        const formData = new FormData(this);

        fetch('{{ route("contact.send") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json' // Meminta respons JSON
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Sukses', data.message, 'success');
                    this.reset();
                } else {
                    showToast('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(error => {
                console.error(error);
                showToast('Error', 'Gagal mengirim pesan. Silakan coba lagi.', 'error');
            })
            .finally(() => {
                btn.textContent = originalText;
                btn.disabled = false;
            });
    });

    // 2. FUNGSI TOAST (Kecil & Rapi)
    function showToast(title, message, type) {
        const toast = document.getElementById('customToast');
        const titleEl = document.getElementById('toastTitle');
        const msgEl = document.getElementById('toastMessage');
        const iconEl = document.getElementById('toastIcon');

        // Reset class
        toast.className = 'toast-notification active';
        toast.classList.add(type); // success atau error

        // Set konten
        titleEl.textContent = title;
        msgEl.textContent = message;

        // Ikon
        if(type === 'error') {
            iconEl.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        } else {
            iconEl.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        }

        // Auto hide setelah 4 detik
        setTimeout(hideToast, 4000);
    }

    function hideToast() {
        document.getElementById('customToast').classList.remove('active');
    }

    // 3. CEK FLASH SESSION (PENTING: Agar muncul walau halaman direload)
    @if(session('success'))
        document.addEventListener("DOMContentLoaded", function() {
            showToast('Sukses', '{{ session('success') }}', 'success');
        });
    @endif

    @if(session('error'))
        document.addEventListener("DOMContentLoaded", function() {
            showToast('Error', '{{ session('error') }}', 'error');
        });
    @endif
</script>
