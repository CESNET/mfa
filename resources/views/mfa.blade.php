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

        <div class="rounded-xl shadow">
            <div
                class="sm:p-8 dark:bg-gray-800 dark:border-gray-500 bg-gradient-to-br from-gray-100 dark:from-gray-800 to-gray-100 dark:to-gray-800 via-gray-200 dark:via-gray-900 p-4 bg-gray-100 border rounded shadow-md">
                <div
                    class="max-w-7xl sm:px-6 lg:flex lg:items-center lg:justify-between lg:py-16 lg:px-8 px-4 py-12 mx-auto">
                    <h2 class="sm:text-4xl text-3xl font-bold tracking-tight">
                        @if (array_key_exists('statusCode2', $e) &&
                                urldecode($e['statusCode2']) === 'urn:oasis:names:tc:SAML:2.0:status:NoAuthnContext')
                            <span class="block text-indigo-600">{{ __('common.sorry') }}</span>
                            <span class="block">{{ __('common.mfa_not_working') }}</span>
                        @else
                            <span class="block text-indigo-600">{{ __('common.congratulations') }}</span>
                            <span class="block">{{ __('common.mfa_working') }}</span>
                        @endif
                    </h2>
                </div>
            </div>
        </div>

        <div class="dark:bg-gray-800 dark:border-gray-500 mt-4 overflow-x-auto bg-white border rounded shadow-md">

            <table class="min-w-full border-gray-300 shadow">

                <thead>
                    <tr>
                        <th
                            class="bg-gray-50 dark:bg-gray-900 dark:text-gray-400 dark:border-b-gray-500 px-6 py-3 text-xs tracking-widest text-left text-gray-700 uppercase border-b">
                            {{ __('common.attribute') }}</th>
                        <th
                            class="bg-gray-50 dark:bg-gray-900 dark:text-gray-400 dark:border-b-gray-500 px-6 py-3 text-xs tracking-widest text-left text-gray-700 uppercase border-b">
                            {{ __('common.value') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-gray-200">

                    @forelse ($e as $key => $value)
                        <tr
                            class="even:bg-gray-50 even:dark:bg-gray-900 even:dark:text-gray-400 even:text-gray-700 hover:bg-blue-100 dark:hover:bg-indigo-300 dark:hover:text-gray-800">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ $key }}</td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ urldecode($value) }}</td>
                        </tr>
                    @empty
                        <tr
                            class="even:bg-gray-50 even:dark:bg-gray-900 even:dark:text-gray-400 even:text-gray-700 hover:bg-blue-100 dark:hover:bg-indigo-300 dark:hover:text-gray-800">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ __('common.shib-authncontext-class') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ $_SERVER['Shib-AuthnContext-Class'] }}
                            </td>
                        </tr>

                        <tr
                            class="even:bg-gray-50 even:dark:bg-gray-900 even:dark:text-gray-400 even:text-gray-700 hover:bg-blue-100 dark:hover:bg-indigo-300 dark:hover:text-gray-800">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ __('common.shib-authentication-method') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ $_SERVER['Shib-Authentication-Method'] }}
                            </td>
                        </tr>

                        <tr
                            class="even:bg-gray-50 even:dark:bg-gray-900 even:dark:text-gray-400 even:text-gray-700 hover:bg-blue-100 dark:hover:bg-indigo-300 dark:hover:text-gray-800">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ __('common.shib-authentication-instant') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ $_SERVER['Shib-Authentication-Instant'] }}
                            </td>
                        </tr>

                        <tr
                            class="even:bg-gray-50 even:dark:bg-gray-900 even:dark:text-gray-400 even:text-gray-700 hover:bg-blue-100 dark:hover:bg-indigo-300 dark:hover:text-gray-800">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ __('common.shib-identity-provider') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ $_SERVER['Shib-Identity-Provider'] }}
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>
