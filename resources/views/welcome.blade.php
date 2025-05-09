<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Barangay SPOT - Community Connection Platform</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700|instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>/* Fallback styles would go here */</style>
        @endif
    </head>
    <body class="bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-100 min-h-screen">
        <header class="w-full px-6 py-6 sm:px-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <!-- Logo -->
                    <div class="flex items-center justify-center w-10 h-10 bg-blue-600 dark:bg-blue-500 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold">Barangay <span class="text-blue-600 dark:text-blue-400">SPOT</span></h1>
                </div>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors shadow-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 border border-transparent hover:border-blue-600 dark:hover:border-blue-400 rounded-md transition-colors">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors shadow-sm">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main class="w-full max-w-7xl mx-auto px-3 sm:px-1 space-y-20">
            <!-- Hero Section -->
           <div class="min-h-screen flex items-center py-1">
    <div class="flex flex-col-reverse lg:flex-row items-center gap-20 w-full">
                <div class="w-full lg:w-1/2 space-y-6">
                    <h2 class="text-4xl md:text-5xl font-bold leading-tight">Connect with your <span class="text-blue-600 dark:text-blue-400">Barangay</span> like never before</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300">SPOT is your community's dedicated social platform where neighbors share updates, report concerns, and stay informed about important announcements.</p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors shadow-md">
                                Join Your Community
                            </a>
                            <a href="#features" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-600 dark:text-blue-400 border border-blue-600 dark:border-blue-400 hover:bg-blue-50 dark:hover:bg-gray-800 rounded-md transition-colors">
                                Learn More
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors shadow-md">
                                Go to Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
                <div class="w-full lg:w-1/2">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur-lg opacity-30 dark:opacity-50"></div>
                        <div class="relative bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl">
                            <!-- Sample Post UI -->
                            <div class="space-y-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-300">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">Barangay Captain</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">2 hours ago</p>
                                    </div>
                                </div>
                                <p class="text-sm">🚨 Important Announcement: Community cleanup drive this Saturday at 7AM. Please bring gloves and join us to keep our barangay clean and beautiful! Meet at the plaza. #BarangayCleanup</p>
                                <div class="bg-blue-50 dark:bg-gray-700 px-4 py-3 rounded">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-blue-800 dark:text-blue-300">Community Announcement</span>
                                        <span class="text-xs bg-blue-200 dark:bg-blue-800 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">Official</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center gap-4">
                                        <button class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                            </svg>
                                            24
                                        </button>
                                        <button class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                            </svg>
                                            8
                                        </button>
                                    </div>
                                    <button class="text-sm text-blue-600 dark:text-blue-400 font-medium">Share</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
            <!-- Feature Section -->
            <section id="features" class="min-h-screen flex flex-col justify-center py-2">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold mb-4">Why Join Barangay SPOT?</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">Our platform connects neighbors, local officials, and community services to build a stronger, more engaged barangay.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:transform hover:scale-105">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Community News</h3>
                        <p class="text-gray-600 dark:text-gray-300">Stay updated with the latest announcements, events, and news from barangay officials and neighbors.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:transform hover:scale-105">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Safety Reports</h3>
                        <p class="text-gray-600 dark:text-gray-300">Report incidents, safety concerns, or infrastructure issues directly to local officials for quick resolution.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:transform hover:scale-105">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Community Projects</h3>
                        <p class="text-gray-600 dark:text-gray-300">Collaborate on neighborhood initiatives, volunteer opportunities, and community improvement projects.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:transform hover:scale-105">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Events Calendar</h3>
                        <p class="text-gray-600 dark:text-gray-300">Never miss important community events, meetings, celebrations, and local gatherings.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:transform hover:scale-105">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Direct Communication</h3>
                        <p class="text-gray-600 dark:text-gray-300">Connect directly with barangay officials and service providers for inquiries and assistance.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md transition-transform hover:transform hover:scale-105">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Service Access</h3>
                        <p class="text-gray-600 dark:text-gray-300">Easy access to information about barangay services, requirements, and procedures in one place.</p>
                    </div>
                </div>
            </section>

            <!-- How It Works Section -->
            <section class="py-12">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">How Barangay SPOT Works</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">A simple platform that connects everyone in the community</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-xl font-bold text-blue-600 dark:text-blue-400">1</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Sign Up</h3>
                        <p class="text-gray-600 dark:text-gray-300">Create your account using your barangay ID or proof of residency</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-xl font-bold text-blue-600 dark:text-blue-400">2</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Connect</h3>
                        <p class="text-gray-600 dark:text-gray-300">Follow barangay officials and join community groups</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-xl font-bold text-blue-600 dark:text-blue-400">3</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Participate</h3>
                        <p class="text-gray-600 dark:text-gray-300">Post updates, report concerns, and engage with community content</p>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="py-12">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-8 md:p-12 text-white text-center">
                <h2 class="text-3xl font-bold mb-4">Join Your Barangay Community Today</h2>
                    <p class="text-lg mb-8 max-w-3xl mx-auto">Be part of a connected community where your voice matters and you stay informed about everything happening in your barangay.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-600 bg-white hover:bg-blue-50 rounded-md transition-colors shadow-md">
                                Create Your Account
                            </a>
                            <a href="#features" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-white hover:bg-blue-600 rounded-md transition-colors">
                                Learn More
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-600 bg-white hover:bg-blue-50 rounded-md transition-colors shadow-md">
                                Go to Dashboard
                            </a>
                        @endguest
                    </div>
                </div>
            </section>

            <!-- Testimonials Section -->
            <section class="py-12">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4">What Our Community Says</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">Hear from residents who are already using Barangay SPOT</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Maria Santos</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Resident for 15 years</p>
                            </div>
                        </div>
                        <p class="italic text-gray-600 dark:text-gray-300">"I love how easy it is to stay updated with community announcements now. Before SPOT, I would miss important events, but now everything is organized in one place!"</p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Jun Reyes</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Small Business Owner</p>
                            </div>
                        </div>
                        <p class="italic text-gray-600 dark:text-gray-300">"As a local shop owner, this platform has helped me connect with more residents. I can easily share updates about my store and participate in community initiatives."</p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold">Councilor Mendoza</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Barangay Official</p>
                            </div>
                        </div>
                        <p class="italic text-gray-600 dark:text-gray-300">"SPOT has revolutionized how we communicate with our constituents. Broadcasting announcements is easier and we get more participation in community programs."</p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-100 dark:bg-gray-900 w-full px-6 py-8 sm:px-10">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-3 gap-8 mb-8">
                    <div>
                        <div class="flex items-center space-x-2 mb-4">
                            <!-- Logo -->
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-600 dark:bg-blue-500 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <h1 class="text-lg font-bold">Barangay <span class="text-blue-600 dark:text-blue-400">SPOT</span></h1>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Connecting communities, fostering engagement, and building stronger neighborhoods.</p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 hover:text-blue-600 dark:hover:text-blue-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <li><a href="#features" class="hover:text-blue-600 dark:hover:text-blue-400">Features</a></li>
                            <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">About Us</a></li>
                            <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-blue-600 dark:hover:text-blue-400">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Subscribe to our newsletter for community updates</p>
                        <form class="flex flex-col sm:flex-row gap-2">
                            <input type="email" placeholder="Your email" class="px-4 py-2 rounded-md border border-gray-300 dark:border-gray-700 dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} Barangay SPOT. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>