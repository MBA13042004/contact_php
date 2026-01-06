<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-slate-900 antialiased">
    <!-- Navbar -->
    <nav class="border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold tracking-tight text-slate-900">Contact App</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="https://laravel.com/docs" target="_blank"
                        class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Documentation</a>
                    <a href="{{ route('contacts.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition-colors">
                        Go to App
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="relative overflow-hidden pt-16 pb-32 space-y-24">
        <div class="relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="mx-auto max-w-2xl text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-6xl mb-6">
                        Manage your contacts <br>
                        <span class="text-blue-600">simpler and faster.</span>
                    </h1>
                    <p class="mt-4 text-lg leading-8 text-slate-600 mb-8">
                        A powerful contact management solution deployed on Kubernetes. Secure, scalable, and designed
                        for efficiency.
                    </p>
                    <div class="flex items-center justify-center gap-x-6">
                        <a href="{{ route('contacts.index') }}"
                            class="rounded-full bg-blue-600 px-8 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all hover:scale-105">
                            Get Started
                        </a>
                        <a href="#"
                            class="text-sm font-semibold leading-6 text-slate-900 flex items-center gap-1 hover:gap-2 transition-all">
                            Learn more <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Simple decorative background pattern -->
            <div
                class="absolute inset-y-0 right-1/2 -z-10 mr-16 w-[200%] origin-bottom-left skew-x-[-30deg] bg-white shadow-xl shadow-blue-600/10 ring-1 ring-blue-50 sm:mr-28 lg:mr-0 xl:mr-16 xl:origin-center">
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="mx-auto max-w-7xl px-6 lg:px-8 pb-24">
        <div class="grid grid-cols-1 gap-y-16 gap-x-8 lg:grid-cols-3">
            <div class="text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="mt-6 text-base font-semibold leading-7 text-slate-900">Kubernetes Native</h3>
                <p class="mt-2 text-base leading-7 text-slate-600">Deploy and scale effortlessly with our k8s
                    configurations.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mt-6 text-base font-semibold leading-7 text-slate-900">Always Reliable</h3>
                <p class="mt-2 text-base leading-7 text-slate-600">Built with Laravel 12.x for maximum stability and
                    performance.</p>
            </div>
            <div class="text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-pink-50">
                    <svg class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    </svg>
                </div>
                <h3 class="mt-6 text-base font-semibold leading-7 text-slate-900">Modern Design</h3>
                <p class="mt-2 text-base leading-7 text-slate-600">Clean, crisp, and focused on your content.</p>
            </div>
        </div>
    </div>
</body>

</html>