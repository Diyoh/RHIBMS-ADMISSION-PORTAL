<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto">
    <div class="glass-effect rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-indigo-900 px-8 py-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-white mb-1">Staff Dashboard</h2>
                <p class="text-indigo-200 text-sm">Welcome back. Here are the latest student admissions.</p>
            </div>
            
            <a href="/admission" class="px-4 py-2 bg-indigo-700 hover:bg-indigo-600 text-white rounded-lg transition text-sm font-semibold shadow">
                View Frontend Portal
            </a>
        </div>
        
        <div class="p-8">
            <!-- This is a placeholder since we haven't built the Admin Controller data pipeline yet, 
                 but it shows how the view is protected by the AuthFilter! -->
            
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-medium">
                            This page is protected by the <code>AuthFilter</code> middleware. Only users with the 'admin' or 'staff' role can see this.
                            If you bypassed the login logic in the filter to view this, you are seeing the secure area!
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 rounded-xl overflow-hidden shadow-sm border border-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Admission ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Course</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Example Row -->
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">ADM-2026-X8P4Q</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">John Doe</div>
                                <div class="text-sm text-gray-500">john.doe@example.com</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Software Engineering</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2026-02-27</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>

<?= $this->endSection() ?>
