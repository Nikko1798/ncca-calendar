<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $status ?? 500 }} - {{ $title ?? 'Error' }}</title>

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-100">
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-xl rounded-2xl bg-white p-8 shadow-xl">

            <div class="text-center">
                <div class="mb-4 text-6xl font-extrabold text-red-500">
                    {{ $status ?? 500 }}
                </div>

                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $title ?? 'Something went wrong' }}
                </h1>

                <p class="mt-4 text-gray-600 break-words whitespace-pre-wrap">
                    {{ $message ?? 'An unexpected error occurred.' }}
                </p>
            </div>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                <button
                    onclick="window.history.back()"
                    class="rounded-lg bg-gray-200 px-5 py-2.5 font-medium text-gray-700 transition hover:bg-gray-300"
                >
                    Go Back
                </button>

                <a
                    href="{{ url('/') }}"
                    class="rounded-lg bg-blue-600 px-5 py-2.5 text-center font-medium text-white transition hover:bg-blue-700"
                >
                    Go to Home
                </a>
            </div>

            @if(app()->isLocal())
                <div class="mt-8 rounded-lg border border-red-200 bg-red-50 p-4">
                    <h2 class="mb-2 font-semibold text-red-700">
                        Debug Information
                    </h2>

                    <pre class="overflow-x-auto text-sm text-red-800 whitespace-pre-wrap">{{ $message }}</pre>
                </div>
            @endif

        </div>
    </div>
</body>
</html>