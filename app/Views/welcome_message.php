<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RHIBMS University Portal</title>
    
    <!-- 
      Tailwind CSS CDN: 
      Tailwind is a "utility-first" framework. Instead of writing custom CSS, 
      we apply pre-built classes directly in the HTML to style elements rapidly.
    -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Using 'Inter' for a clean, modern, professional look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Base typography setup */
        body { font-family: 'Inter', sans-serif; }
        
        /* 
         * Custom "Glassmorphism" CSS class. 
         * While Tailwind can do this, sometimes writing a custom class is cleaner 
         * for complex visual effects used inside specific components.
         */
        .glass-effect {
            background: rgba(255, 255, 255, 0.4); 
            backdrop-filter: blur(16px); /* Blurs the background behind this element */
            -webkit-backdrop-filter: blur(16px); /* For Safari support */
            border: 1px solid rgba(255, 255, 255, 0.6); /* Subtle white border */
        }
    </style>
</head>

<!-- 
  BODY STYLING:
  - bg-gray-50: Sets a very light gray background.
  - flex flex-col min-h-screen: Ensures the footer is always pushed to the bottom of the screen.
  - antialiased: Makes fonts look smoother on Mac/iOS devices.
  - text-gray-900: Sets the default text color to a near-black for high contrast/readability.
-->
<body class="bg-gray-50 flex flex-col min-h-screen antialiased text-gray-900">

    <!-- 
      NAVIGATION HEADER STYLING:
      - bg-white/90: White background with 90% opacity (slightly transparent).
      - backdrop-blur-md: Blurs what is behind the header as you scroll down.
      - fixed w-full z-50: Sticks the header to the top of the browser window.
    -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm fixed w-full z-50">
        <!-- max-w-7xl mx-auto: Centers the content and prevents it from getting too wide on huge monitors -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            
            <div class="flex items-center">
                <!-- Clickable Logo -->
                <a href="/" class="flex items-center group">
                    <div class="w-10 h-10 bg-gradient-to-tr from-indigo-700 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-3 shadow-lg group-hover:scale-105 transition-transform duration-300">
                        <img src="<?= base_url('logo.png') ?>" alt="RHIBMS Logo" class="w-8 h-8 object-contain hidden" onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');" />
                        <span class="logo-fallback text-white font-bold">R</span>
                    </div>
                    <h1 class="text-2xl font-extrabold text-indigo-900 tracking-tight transition-colors group-hover:text-indigo-700">RHIBMS <span class="text-indigo-500 font-medium">Portal</span></h1>
                </a>
            </div>
            
            <!-- 
              RESPONSIVE NAVIGATION:
              - hidden md:flex: Hides these links on mobile phones (hidden), but displays them as a flexbox on tablets and desktops (md:flex).
            -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1">Home</a>
                <!-- hover:text-indigo-600 transition-colors: Smoothly changes color when hovering with the mouse -->
                <a href="#academics" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Academics</a>
                <a href="#campus" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Campus Life</a>
            </nav>
            
            <div class="flex space-x-4">
                <!-- 
                  BUTTON STYLING:
                  - transform hover:-translate-y-0.5: Moves the button slightly UP when hovered, making it feel interactive and alive!
                -->
                <a href="/admission" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md transition-all transform hover:-translate-y-0.5">Apply Now</a>
            </div>
        </div>
    </header>

    <!-- Main Hero Section -->
    <main class="flex-grow pt-20">
        <!-- min-h-[85vh]: Forces this section to take up at least 85% of the browser's Height -->
        <div class="relative bg-white overflow-hidden min-h-[85vh] flex items-center">
            
            <!-- 
              DECORATIVE BACKGROUND BLOBS:
              We use absolute positioning to place huge, blurred, colored circles in the corners to create a dreamy, modern background.
            -->
            <div class="absolute inset-0 bg-indigo-50">
                <!-- blur-3xl opacity-50: Makes the circle look like a soft glowing cloud -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[40rem] h-[40rem] bg-indigo-100 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[30rem] h-[30rem] bg-pink-100 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full py-16">
                <!-- 
                  CSS GRID LAYOUT:
                  - lg:grid-cols-12: On large screens, split the page into 12 invisible columns.
                  This allows us to place text on the left (spanning 6 columns) and the image on the right (spanning 6 columns).
                -->
                <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                    
                    <!-- LEFT COLUMN (TEXT) - Spans 6 columns on large screens -->
                    <div class="lg:col-span-6 text-center lg:text-left">
                        
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-100 text-indigo-800 font-semibold text-sm mb-6 border border-indigo-200">
                            <!-- animate-pulse: Makes the small dot flash slowly like a recording light -->
                            <span class="flex h-2 w-2 rounded-full bg-indigo-600 mr-2 animate-pulse"></span>
                            Admissions for 2026 are now open!
                        </div>
                        
                        <!-- 
                          GRADIENT TEXT:
                          - text-transparent bg-clip-text bg-gradient-to-r: Cuts out the text shape from the gradient background beneath it!
                        -->
                        <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                            Build Your <br class="hidden lg:block">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Future Here.</span>
                        </h1>
                        
                        <p class="mt-4 text-xl text-gray-600 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-medium">
                            Join RHIBMS University to experience world-class education, cutting-edge technology integration, and an environment designed for ultimate success.
                        </p>
                        
                        <!-- Actions / Buttons -->
                        <div class="flex flex-col sm:flex-row justify-center lg:justify-start space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="/admission" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 flex justify-center items-center">
                                Start Application Process
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <a href="/admin/dashboard" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl shadow border border-indigo-100 hover:bg-indigo-50 transition-colors flex justify-center items-center">
                                Staff Login
                            </a>
                        </div>
                    </div>
                    
                    <!-- 
                      RIGHT COLUMN (IMAGE) - Spans 6 columns on large screens.
                      - hidden lg:block: Completely hides the image on mobile phones to save space!
                    -->
                    <div class="hidden lg:block lg:col-span-6 relative">
                        
                        <!-- aspect-square: Forces the container to be a perfect square -->
                        <div class="relative w-full aspect-square max-w-lg mx-auto">
                            <!-- rotata-6: Tilts the decorative background shadow slightly -->
                            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-[3rem] rotate-6 opacity-20 blur-lg"></div>
                            
                            <!-- glass-effect: Applies our custom CSS class from the head -->
                            <div class="relative h-full w-full bg-indigo-50 rounded-[3rem] shadow-2xl overflow-hidden border border-white/40 p-2 glass-effect flex flex-col pt-8">
                                <!-- 
                                  IMAGE FILTERS:
                                  - object-cover: Ensures the image fills the box without stretching/distorting.
                                  - grayscale-[20%] sepia-[10%] hue-rotate-[-10deg]: Fine-tunes the photo colors directly in CSS!
                                -->
                                <img src="<?= base_url('Students.jpeg') ?>" alt="RHIBMS University Students" class="rounded-[2.5rem] object-cover h-full w-full shadow-inner grayscale-[20%] sepia-[10%] hue-rotate-[-10deg]">
                            </div>
                            
                            <!-- Floating 'Acceptance' Badge -->
                            <!-- animate-bounce: Makes the badge float up and down to catch attention -->
                            <div class="absolute -left-8 top-1/4 bg-white p-4 rounded-2xl shadow-xl border border-gray-100 animate-bounce" style="animation-duration: 3s;">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium">Acceptance</p>
                                        <p class="text-lg font-bold text-gray-900">100% Guaranteed</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm font-medium">
            <p>&copy; <?= date('Y') ?> RHIBMS University. Admission System Module - Week 5 with Mr Diyoh Shiloh.</p>
        </div>
    </footer>

</body>
</html>
