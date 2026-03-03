<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-3xl mx-auto">
    
    <!-- Success Message Alert (Read from Flashdata) -->
    <?php if (session()->getFlashdata('success_message')): ?>
        <div class="mb-8 p-6 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm animate-fade-in-down">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-green-800">Application Successful</h3>
                    <div class="mt-2 text-sm text-green-700">
                        <p><?= esc(session()->getFlashdata('success_message')) ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Validation Errors Alert (Read from Session) -->
    <?php if (session()->get('errors')): ?>
        <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm animate-fade-in-down">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-red-800">Please correct the following errors:</h3>
                    <div class="mt-2 text-sm text-red-700 font-medium">
                        <ul class="list-disc pl-5 space-y-1">
                            <?php foreach (session()->get('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- The Main Form Card -->
    <div class="glass-effect rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        <div class="bg-gradient-to-r from-indigo-700 to-indigo-600 px-8 py-8 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
            <h2 class="text-3xl font-bold text-white mb-2 relative z-10">Student Admission Portal</h2>
            <p class="text-indigo-100 font-medium relative z-10">Join RHIMBS and start your journey towards excellence. Fill out the application securely below.</p>
        </div>
        
        <form action="/admission/submit" method="post" class="p-8 space-y-6">
            
            <!-- EXTREMELY IMPORTANT: CSRF Protection! The framework will automatically reject submissions without this hidden token -->
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First Name</label>
                    <input type="text" name="first_name" id="first_name" value="<?= set_value('first_name') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm outline-none bg-white/70" placeholder="John">
                </div>
                
                <div>
                    <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name</label>
                    <input type="text" name="last_name" id="last_name" value="<?= set_value('last_name') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm outline-none bg-white/70" placeholder="Doe">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="<?= set_value('email') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm outline-none bg-white/70" placeholder="john.doe@example.com">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="<?= set_value('phone') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm outline-none bg-white/70" placeholder="+237 600000000">
                </div>
                
                <div>
                    <label for="dob" class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" name="dob" id="dob" value="<?= set_value('dob') ?>" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm outline-none bg-white/70">
                </div>
            </div>

            <div>
                <label for="course" class="block text-sm font-semibold text-gray-700 mb-2">Program of Study</label>
                <select name="course" id="course" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors shadow-sm outline-none bg-white/70 font-medium text-gray-700">
                    <option value="" disabled selected>Select a program...</option>
                    <option value="Software Engineering" <?= set_select('course', 'Software Engineering') ?>>Software Engineering (SWE)</option>
                    <option value="Digital Marketing" <?= set_select('course', 'Digital Marketing') ?>>Digital Marketing (Performance Strategy)</option>
                    <option value="Advanced Graphic Design" <?= set_select('course', 'Advanced Graphic Design') ?>>UI/UX & WordPress Engineering</option>
                </select>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    Submit Secure Application
                </button>
            </div>
            
            <p class="text-xs text-center text-gray-500 mt-6 font-medium">
                <svg class="w-4 h-4 inline-block mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                This form is protected by Global CSRF Security and XSS Sanitization Filters.
            </p>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
