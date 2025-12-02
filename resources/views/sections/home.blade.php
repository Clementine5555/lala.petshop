<section id="home" style="min-height: 100vh; position: relative; display: flex; align-items: center;">
    <style>
        #home {
        background:
        linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)),
        url('{{ asset('img/background.jpeg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }


        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 50px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-content {
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.5em;
            font-style: italic;
            margin-bottom: 15px;
            color: #FFE5D9;
            font-weight: 400;
        }

        .hero-title {
            font-size: 4em;
            font-weight: 800;
            margin-bottom: 25px;
            line-height: 1.1;
            color: white;
        }

        .hero-description {
            font-size: 1.2em;
            line-height: 1.8;
            margin-bottom: 35px;
            color: #FFF;
            opacity: 0.95;
        }

        .hero-btn {
            display: inline-block;
            padding: 16px 45px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2em;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .hero-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(255, 140, 66, 0.6);
        }

        .hero-img {
            position: relative;
        }

        .hero-img img {
            width: 100%;
            height: auto;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @media (max-width: 992px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
                padding: 50px 30px;
            }
            .hero-title { font-size: 3em; }
            .hero-subtitle { font-size: 1.3em; }
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2.5em; }
            .hero-btn { padding: 14px 35px; font-size: 1em; }
        }
    </style>

    <div class="hero-container">
        <div class="hero-content">
            <div class="hero-subtitle">Save Your Next</div>
            <h1 class="hero-title">BEST FRIEND</h1>
            <p class="hero-description">
                Because your pets deserve more than just food they deserve comfort, care, and love.
                Find all their needs here and make every day a little happier for your best friend.
            </p>
            <a href="#products" class="hero-btn">Shop Now!</a>
        </div>

        <div class="hero-img">
    <img src="{{ asset('img/kucinganjing.jpeg') }}" alt="Happy Pet">

        </div>
    </div>
</section>
