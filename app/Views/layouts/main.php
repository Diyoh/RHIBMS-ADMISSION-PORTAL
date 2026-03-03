<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'RHIBMS Admission Portal') ?></title>
    <!-- Use Tailwind CSS for modern, premium styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out;
        }
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen text-gray-800 antialiased flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-indigo-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="/" class="flex items-center group">
                    <div class="w-10 h-10 bg-gradient-to-tr from-indigo-700 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-3 shadow border border-indigo-400 group-hover:scale-105 transition-transform duration-300">
                        <img src="<?= base_url('logo.png') ?>" alt="RHIBMS Logo" class="w-8 h-8 object-contain hidden" onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');" />
                        <span class="logo-fallback text-white font-bold">R</span>
                    </div>
                    <h1 class="text-2xl font-bold text-indigo-900 tracking-tight transition-colors group-hover:text-indigo-700">RHIBMS <span class="text-indigo-500 font-medium hidden sm:inline">Portal</span></h1>
                </a>
            </div>
            <nav class="flex space-x-6 text-sm md:text-base">
                <a href="/admission" class="text-gray-600 hover:text-indigo-600 font-semibold transition-colors">Apply Now</a>
                <a href="/admin/dashboard" class="text-gray-600 hover:text-indigo-600 font-semibold transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Staff
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        <!-- CI4 Template Inheritance: Render the specific child view here -->
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-indigo-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-400 text-sm">
            &copy; <?= date('Y') ?> RHIBMS University. All rights reserved. <br/>
            Built with modern architecture for Week 5 Systems Engineering.
        </div>
    </footer>

</body>
</html>
