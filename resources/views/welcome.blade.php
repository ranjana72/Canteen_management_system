<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Canteen — Academia International College</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Lexend', 'sans-serif'],
                    },
                    colors: {
                        primary: '#212529',
                        secondary: '#0047AB',
                        tertiary: '#7a7a7a'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white text-primary font-sans antialiased">

    <!-- Navbar -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-[10px] bg-secondary flex items-center justify-center text-white text-lg">
                    🍽️
                </div>
                <div class="leading-tight">
                    <div class="font-semibold text-[15px] text-secondary">Academia Canteen</div>
                    <div class="text-[11px] text-tertiary tracking-wide uppercase">Academia International College</div>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8 text-[14px] font-medium">
                <a href="#how-it-works" class="text-tertiary hover:text-secondary transition-colors duration-200">How it works</a>
                <a href="#menu" class="text-tertiary hover:text-secondary transition-colors duration-200">Today's Menu</a>
                <a href="#about" class="text-tertiary hover:text-secondary transition-colors duration-200">About</a>
                <a href="#contact" class="text-tertiary hover:text-secondary transition-colors duration-200">Contact</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/login" class="text-[14px] font-medium text-tertiary hover:text-secondary px-3 py-1.5 transition">
                    Log in
                </a>
                <a href="/register" class="bg-secondary hover:bg-[#003a8c] text-white text-[13px] font-semibold px-5 py-2 rounded-[10px] transition">
                    Get Started
                </a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden bg-[#f8fafc]">
        <div class="max-w-6xl mx-auto px-6 pt-16 pb-20 lg:pt-20 lg:pb-24">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                <div>
                    <div class="inline-flex items-center gap-2 bg-white border border-gray-200 text-secondary text-[12px] font-medium tracking-wide uppercase px-3.5 py-1.5 rounded-full mb-6 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Live at Academia International College
                    </div>

                    <h1 class="text-[34px] sm:text-[40px] font-bold tracking-tight text-primary leading-[1.15] mb-5">
                        Order ahead.<br>
                        <span class="text-secondary">Skip the line.</span>
                    </h1>

                    <p class="text-[17px] text-tertiary leading-relaxed max-w-md mb-8">
                        Browse real-time canteen stock, place your order between classes, and pick it up hot — no queue, no waiting.
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="/student/menu"
                           class="inline-flex items-center justify-center bg-secondary hover:bg-[#003a8c] text-white font-semibold text-[15px] px-7 py-3 rounded-[10px] transition shadow-sm">
                            Order Now
                        </a>
                        <a href="#how-it-works"
                           class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-primary font-medium text-[15px] px-7 py-3 rounded-[10px] border border-gray-200 transition">
                            See how it works
                        </a>
                    </div>
                </div>

                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative bg-white rounded-[20px] shadow-lg shadow-gray-200/70 border border-gray-100 w-full max-w-[320px] overflow-hidden">

                        <div class="h-1 bg-gradient-to-r from-secondary to-blue-400"></div>

                        <div class="p-5">
                            <div class="relative h-40 rounded-[14px] bg-gradient-to-br from-secondary to-[#001a38] flex items-center justify-center mb-4 overflow-hidden">
                                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,white,transparent_60%)]"></div>
                                <div class="relative flex flex-col items-center gap-1.5">
                                    <span class="w-11 h-11 rounded-full bg-white/15 flex items-center justify-center text-xl">🥟</span>
                                    <span class="text-white text-[13px] font-semibold">Chicken Momo Set</span>
                                </div>

                                <div class="absolute top-3 right-3 bg-white text-secondary font-bold text-[13px] px-3 py-1 rounded-[8px] shadow-sm">
                                    Rs. 120
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-[15px] text-primary">Chicken Momo Set</h3>
                            </div>
                            <div class="mt-1.5 inline-flex items-center gap-1.5 text-[12px] font-medium text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-[6px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                In Stock · 24 left
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- How it works -->
    <section id="how-it-works" class="bg-white border-t border-gray-100 py-16">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-[28px] sm:text-[34px] font-bold tracking-tight text-primary mb-3">
                How it works
            </h2>
            <p class="text-tertiary text-[16px] max-w-md mx-auto">
                Three simple steps to get your food without waiting in line.
            </p>
        </div>
    </section>

</body>
</html>