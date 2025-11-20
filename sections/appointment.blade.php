<section id="appointment" style="min-height: 100vh; padding: 120px 0; background: linear-gradient(135deg, #FFF5EB 0%, #FFE5D9 100%);">
    <style>
        .appointment-container {
            max-width: 1200px; 
            margin: 0 auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-title h2 {
            font-size: 3.5em; 
            color: #333;
            margin-bottom: 20px;
            font-weight: 800;
        }

        .section-title p {
            font-size: 1.4em;
            color: #666;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px; 
            margin-bottom: 70px;
        }

        .step-card {
            background: white;
            border-radius: 25px;
            padding: 50px 35px; 
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .step-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 45px rgba(255, 140, 66, 0.25);
        }

        .step-number {
            width: 95px; 
            height: 95px; 
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 3em; 
            font-weight: 800;
            color: white;
            box-shadow: 0 8px 20px rgba(255, 140, 66, 0.3);
        }

        .step-card h3 {
            font-size: 1.8em; 
            color: #333;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .step-card p {
            color: #666;
            font-size: 1.2em; 
            line-height: 1.7;
        }

        .cta-button {
            text-align: center;
        }

        .btn-book {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 26px 75px; 
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.4em; 
            transition: all 0.3s;
            box-shadow: 0 8px 30px rgba(255, 140, 66, 0.5);
        }

        .btn-book:hover {
            transform: translateY(-4px);
        }

        @media (max-width: 1200px) {
            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }

            .section-title h2 {
                font-size: 2.5em;
            }
        }
    </style>

    <div class="appointment-container">
        <div class="section-title">
            <h2>How to Book Appointment</h2>
            <p>Easy steps to schedule your pet's care</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Register Pet</h3>
                <p>Daftarkan pet Anda dengan data lengkap </p>
            </div>

            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Choose Service</h3>
                <p>Pilih layanan yang Anda inginkan dari tersedia </p>
            </div>

            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Confirmation</h3>
                <p>Cek kembali layanan yg anda pilih</p>
            </div>

            <div class="step-card">
                <div class="step-number">4</div>
                <h3>Waiting</h3>
                <p>Tunggu konfirmasi dari admin, cek status appointment Anda</p>
            </div>
        </div>

        <div class="cta-button">
            <a href="{{ route('appointment.create') }}" class="btn-book">
                See more
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
