<section id="home" style="min-height: 100vh; position: relative; display: flex; align-items: center; overflow: hidden;">
    <style>
        #home {
            position: relative;
        }

        /* Slider Background Images */
        .hero-bg-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .hero-bg-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-bg-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4));
            z-index: 1;
        }

        .hero-bg-slide.active {
            opacity: 1;
            z-index: 1;
        }

        /* Container - Align Left */
        .hero-container {
            max-width: 100%;
            width: 100%;
            margin: 0;
            padding: 0 50px 0 50px;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            color: white;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            max-width: 700px;
            text-align: left;
        }

        .hero-subtitle {
            font-size: 1.8em;
            font-style: italic;
            margin-bottom: 20px;
            color: #FFE5D9;
            font-weight: 400;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 0.8s ease-out 0.2s forwards;
        }

        .hero-title {
            font-size: 5em;
            font-weight: 900;
            margin-bottom: 30px;
            line-height: 1.1;
            color: white;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 0.8s ease-out 0.4s forwards;
        }

        .hero-description {
            font-size: 1.3em;
            line-height: 1.8;
            margin-bottom: 40px;
            color: #FFF;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInDown 0.8s ease-out 0.6s forwards;
        }

        .hero-btn {
            display: inline-block;
            padding: 18px 50px;
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.3em;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(255, 140, 66, 0.5);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out 0.8s forwards;
        }

        .hero-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 140, 66, 0.7);
        }

        @keyframes fadeInDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Slider Controls */
        .slider-controls {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 10;
        }

        .slider-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.4s;
            border: 2px solid white;
        }

        .slider-dot:hover {
            background: rgba(255, 255, 255, 0.7);
        }

        .slider-dot.active {
            background: #FF8C42;
            width: 40px;
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-container {
                padding: 50px 40px;
            }
            .hero-title { font-size: 3.5em; }
            .hero-subtitle { font-size: 1.5em; }
            .hero-description { font-size: 1.15em; }
        }

        @media (max-width: 768px) {
            .hero-container {
                padding: 50px 25px;
            }
            .hero-content {
                text-align: center;
            }
            .hero-title { font-size: 2.8em; }
            .hero-subtitle { font-size: 1.2em; }
            .hero-description { font-size: 1em; }
            .hero-btn { padding: 15px 35px; font-size: 1.1em; }
            .slider-controls { bottom: 30px; }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 2.2em; }
        }
    </style>

    <!-- Background Slider - 4 Gambar -->
    <div class="hero-bg-slider">
        <div class="hero-bg-slide active" style="background-image: url('{{ asset('images/anj.jpg') }}');"></div>
        <div class="hero-bg-slide" style="background-image: url('{{ asset('images/anjingg.jpg') }}');"></div>
        <div class="hero-bg-slide" style="background-image: url('{{ asset('images/anjingkucing.jpeg') }}');"></div>
        <div class="hero-bg-slide" style="background-image: url('{{ asset('images/KUCING.jpeg') }}');"></div>
    </div>

    <!-- Content Container -->
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
    </div>

    <!-- Slider Controls -->
    <div class="slider-controls">
        <span class="slider-dot active" onclick="goToSlide(0)"></span>
        <span class="slider-dot" onclick="goToSlide(1)"></span>
        <span class="slider-dot" onclick="goToSlide(2)"></span>
        <span class="slider-dot" onclick="goToSlide(3)"></span>
    </div>

    <script>
        let currentHeroSlide = 0;
        const bgSlides = document.querySelectorAll('.hero-bg-slide');
        const dots = document.querySelectorAll('.slider-dot');
        let heroSlideInterval;

        function showHeroSlide(index) {
            // Reset all slides
            bgSlides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            // Handle index boundaries
            if (index >= bgSlides.length) {
                currentHeroSlide = 0;
            } else if (index < 0) {
                currentHeroSlide = bgSlides.length - 1;
            } else {
                currentHeroSlide = index;
            }

            // Show new slide
            bgSlides[currentHeroSlide].classList.add('active');
            dots[currentHeroSlide].classList.add('active');
        }

        function goToSlide(index) {
            showHeroSlide(index);
            resetHeroInterval();
        }

        function startHeroAutoSlide() {
            heroSlideInterval = setInterval(() => {
                showHeroSlide(currentHeroSlide + 1);
            }, 5000); // Ganti setiap 3 detik (lebih cepat!)
        }

        function resetHeroInterval() {
            clearInterval(heroSlideInterval);
            startHeroAutoSlide();
        }

        // Start auto slide when page loads
        document.addEventListener('DOMContentLoaded', function() {
            showHeroSlide(0);
            startHeroAutoSlide();
        });

        // Pause on hover (optional)
        const homeSection = document.getElementById('home');
        homeSection.addEventListener('mouseenter', () => {
            clearInterval(heroSlideInterval);
        });

        homeSection.addEventListener('mouseleave', () => {
            startHeroAutoSlide();
        });
    </script>
</section>