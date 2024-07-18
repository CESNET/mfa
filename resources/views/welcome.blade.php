<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
</head>

<body class="sm:p-16 bg-gray-50 dark:bg-gray-900 dark:text-gray-400 p-4 antialiased text-gray-700">

    <div class="max-w-screen-md mx-auto">

        <div
            class="sm:p-8 dark:bg-gray-800 dark:border-gray-500 bg-gradient-to-br from-gray-100 dark:from-gray-800 to-gray-100 dark:to-gray-800 via-gray-200 dark:via-gray-900 p-4 bg-gray-100 border rounded shadow-md">

            <header>
                <h1 class="sm:text-5xl pb-4 text-4xl font-bold tracking-wider">{{ config('app.name') }}</h1>
                <p class="pb-4 font-bold text-right text-blue-500">[
                    @if (App::currentLocale() == 'cs')
                        <a href="/language/en">
                        @else
                            <a href="/language/cs">
                    @endif
                    {{ __('common.switch_language') }}</a>
                    ]
                </p>
                <p class="sm:text-lg leading-relaxed">{!! __('common.introduction') !!}</p>
                <div
                    class="bg-gradient-to-r from-gray-100 dark:from-gray-800 to-gray-100 dark:to-gray-800 via-gray-800 dark:via-gray-100 w-full h-px my-8">
                </div>
                <hr class="hidden">
            </header>

            <main class="sm:pb-8 pb-4">
                <p class="pb-4">{!! __('common.description') !!}</p>

                <p class="sm:pt-10 pt-6 text-center">
                    <a class="md:inline-block hover:bg-blue-600 text-blue-50 hover:shadow-lg block px-6 py-3 font-bold bg-blue-500 rounded shadow"
                        href="/login">{{ __('common.login-mfa') }}</a>
                </p>
            </main>

            <footer>
                <div
                    class="bg-gradient-to-r from-gray-100 dark:from-gray-800 to-gray-100 dark:to-gray-800 via-gray-300 dark:via-gray-600 w-full h-px mt-4 mb-3">
                </div>
                <hr class="hidden">
                <p class="text-center opacity-75">
                    <small class="text-sm">
                        {{ __('common.no-pii') }}<br>
                        &copy; 2022&ndash;{{ date('Y') }} <a class="hover:underline text-blue-500"
                            href="https://www.cesnet.cz">CESNET</a> &middot;
                        <a class="hover:underline text-blue-500" href="mailto:info@eduid.cz">info@eduid.cz</a>
                    </small>
                </p>
            </footer>

        </div>

    </div>

</body>

</html>
