<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>REQTrack - Track budgets, expenses, and requisitions</title>
    <meta name="description" content="Manage and monitor financial requests, key performance indicators, and accountability submissions with ease.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!--favicon --> 
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 25%, #6366f1 50%, #8b5cf6 75%, #a855f7 100%);
            --secondary-gradient: linear-gradient(135deg, #213172 0%, #4f46e5 50%, #885cf7 100%);
            --accent-color: #f59e0b;
            --text-white: #ffffff;
            --text-gray: #e5e7eb;
            --text-dark: #1f2937;
            --card-bg: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --hover-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-white);
            overflow-x: hidden;
        }

        /* Animated Background */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #213172 0%, #885cf7 100%);
            /* background: #213172; */
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background: 
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 60% 30%, rgba(168, 92, 247, 0.3) 0%, transparent 50%); */
            animation: backgroundShift 20s ease-in-out infinite;
        }

        @keyframes backgroundShift {
            0%, 100% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(-2%) translateY(2%); }
            50% { transform: translateX(2%) translateY(-2%); }
            75% { transform: translateX(-1%) translateY(1%); }
        }

        /* Floating particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }

        .particle:nth-child(1) { width: 4px; height: 4px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; left: 20%; animation-delay: 2s; }
        .particle:nth-child(3) { width: 3px; height: 3px; left: 30%; animation-delay: 4s; }
        .particle:nth-child(4) { width: 5px; height: 5px; left: 40%; animation-delay: 6s; }
        .particle:nth-child(5) { width: 4px; height: 4px; left: 50%; animation-delay: 8s; }
        .particle:nth-child(6) { width: 6px; height: 6px; left: 60%; animation-delay: 10s; }
        .particle:nth-child(7) { width: 3px; height: 3px; left: 70%; animation-delay: 12s; }
        .particle:nth-child(8) { width: 5px; height: 5px; left: 80%; animation-delay: 14s; }
        .particle:nth-child(9) { width: 4px; height: 4px; left: 90%; animation-delay: 16s; }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }

        /* Header */
        .header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.5rem 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--text-white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* .logo-icon::before {
            content: '';
            position: absolute;
            width: 60%;
            height: 60%;
            background: var(--secondary-gradient);
            border-radius: 50%;
            animation: logoSpin 8s linear infinite;
        } */

        @keyframes logoSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .logo-text {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-white);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 100;
            max-width: 1200px;
            width: 100%;
        }

        .hero-title {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            color: var(--text-gray);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 400;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2.5rem;
            background: var(--text-white);
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: var(--hover-shadow);
            color: var(--text-dark);
        }

        .cta-button i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .cta-button:hover i {
            transform: translateX(4px);
        }

        /* Features Section */
        .features-section {
            padding: 6rem 2rem;
            background: var(--text-white);
            position: relative;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
            margin-top: 4rem;
        }

        .feature-card {
            background: var(--card-bg);
            padding: 2.5rem;
            border-radius: 24px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--secondary-gradient);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--secondary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--text-white);
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: var(--secondary-gradient);
            padding: 1rem 2rem;
            text-align: center;
            position: relative;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-text {
            font-size: 1rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                padding: 1rem;
            }

            .header {
                padding: 1rem;
            }

            .logo-text {
                font-size: 1.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .feature-card {
                padding: 2rem;
            }

            .cta-button {
                padding: 0.875rem 2rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
                margin-bottom: 2rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .feature-icon {
                width: 60px;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .loading.loaded {
            opacity: 1;
            transform: translateY(0);
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            color: var(--text-gray);
            font-size: 0.875rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
            40% { transform: translateX(-50%) translateY(-10px); }
            60% { transform: translateX(-50%) translateY(-5px); }
        }

        .scroll-indicator i {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo">
            <div class="logo-icon">
                    <img style="width: 97%; margin-left: 11px; margin-top: 2px" src="{{asset('login-template')}}/images/logo.png">
						
                </div>
            <span class="logo-text">REQTrack</span>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Animated Background Particles -->
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <div class="main-content">
            <h1 class="hero-title loading" data-aos="fade-up" data-aos-duration="1000">
                Track budgets, expenses, and requisitions
            </h1>
            
            <p class="hero-subtitle loading" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                Manage and monitor financial requests, key performance indicators, and accountability submissions with ease.
            </p>
            
            <a href="{{ route('signin') }}" class="cta-button loading" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </a>
        </div>

        <div class="scroll-indicator" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="1000">
            <span>Scroll to explore</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="features-grid">
                <!-- Dashboard Feature -->
                <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="feature-icon">
                        <i class="fas fa-th-large"></i>
                    </div>
                    <h3 class="feature-title">Dashboard</h3>
                    <p class="feature-description">
                        Gain insights into fund request status and financial performance with comprehensive analytics and real-time monitoring.
                    </p>
                </div>

                <!-- Key Performance Feature -->
                <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Key Performance</h3>
                    <p class="feature-description">
                        Monitor requisition counts and approved allowances with advanced KPI tracking and performance metrics.
                    </p>
                </div>

                <!-- Accountability Feature -->
                <div class="feature-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="feature-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h3 class="feature-title">Accountability</h3>
                    <p class="feature-description">
                        Track pending, submitted and reviewed submissions with complete audit trails and transparency.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p class="footer-text">
                <strong>REQTrack</strong> - Powered by Eight Tech Consults Limited
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const loadingElements = document.querySelectorAll('.loading');
            
            setTimeout(() => {
                loadingElements.forEach((el, index) => {
                    setTimeout(() => {
                        el.classList.add('loaded');
                    }, index * 200);
                });
            }, 300);
        });

        // Smooth scrolling for scroll indicator
        document.querySelector('.scroll-indicator').addEventListener('click', function() {
            document.querySelector('.features-section').scrollIntoView({
                behavior: 'smooth'
            });
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-section');
            const speed = scrolled * 0.5;
            
            if (parallax) {
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });

        // Enhanced button interaction
        document.querySelectorAll('.cta-button').forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 35px 60px -12px rgba(0, 0, 0, 0.4)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
            });
        });

        // Feature card hover effects
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Preloader (optional)
        window.addEventListener('load', function() {
            document.body.classList.add('loaded');
        });

        // Responsive navigation handling
        function handleResize() {
            const isMobile = window.innerWidth <= 768;
            const particles = document.querySelectorAll('.particle');
            
            particles.forEach(particle => {
                if (isMobile) {
                    particle.style.display = 'none';
                } else {
                    particle.style.display = 'block';
                }
            });
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Initial call

        // Add subtle cursor trail effect
       /*  document.addEventListener('mousemove', function(e) {
            const cursor = document.querySelector('.cursor-trail');
            if (!cursor) {
                const trail = document.createElement('div');
                trail.className = 'cursor-trail';
                trail.style.cssText = `
                    position: fixed;
                    width: 20px;
                    height: 20px;
                    background: radial-gradient(circle, rgba(168, 92, 247, 0.3) 0%, transparent 70%);
                    border-radius: 50%;
                    pointer-events: none;
                    z-index: 9999;
                    transition: all 0.1s ease;
                `;
                document.body.appendChild(trail);
            }
            
            const trail = document.querySelector('.cursor-trail');
            if (trail) {
                trail.style.left = e.clientX - 10 + 'px';
                trail.style.top = e.clientY - 10 + 'px';
            }
        }); */

        // Performance optimization
        let ticking = false;
        function updateAnimations() {
            // Batch DOM updates here if needed
            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateAnimations);
                ticking = true;
            }
        }

        // Intersection Observer for performance
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                }
            });
        }, observerOptions);

        // Observe all feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>