<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coronavirus Global Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
        <div class="mb-8 flex justify-center">
            <!-- Simple Icon or Logo Placeholder -->
            <div class="bg-red-100 p-4 rounded-full">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight sm:text-6xl mb-4">
            Coronavirus Global Tracker
        </h1>

        <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto mb-10">
            Monitor real-time statistics, track confirmed cases, and stay informed about the global situation with
            accurate data visualization.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/cases') }}"
                class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 md:text-xl transition duration-150 ease-in-out shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                Go to Dashboard
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>

            <!-- Optional Secondary Link -->
            <!-- <a href="#" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 md:text-xl transition duration-150 ease-in-out">
                Learn More
            </a> -->
        </div>

        <footer class="mt-20 text-gray-400 text-sm">
            &copy; {{ date('Y') }} Coronavirus Tracker. All rights reserved.
        </footer>
    </div>

</body>

</html>