<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    @vite('resources/css/app.css')
</head>

<body class="sm:p-16 bg-gray-50 p-4 antialiased text-gray-700">

    <div class="max-w-screen-md mx-auto">

        <div class="rounded-xl shadow">
            <div class="rounded-xl bg-gray-200">
                <div
                    class="max-w-7xl sm:px-6 lg:flex lg:items-center lg:justify-between lg:py-16 lg:px-8 px-4 py-12 mx-auto">
                    <h2 class="sm:text-4xl text-3xl font-bold tracking-tight text-gray-900">
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

        <div class="rounded-xl mt-4 overflow-x-auto bg-white border">

            <table class="min-w-full border-b border-gray-300 shadow">

                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs tracking-widest text-left uppercase bg-gray-100 border-b">
                            {{ __('common.attribute') }}</th>
                        <th class="px-6 py-3 text-xs tracking-widest text-left uppercase bg-gray-100 border-b">
                            {{ __('common.value') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-gray-200">

                    @forelse ($e as $key => $value)
                        <tr class="hover:bg-blue-50 even:bg-gray-50 odd:bg-white">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ $key }}</td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ urldecode($value) }}</td>
                        </tr>
                    @empty
                        <tr class="hover:bg-blue-50 even:bg-gray-50 odd:bg-white">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ __('common.shib-authncontext-class') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">{{ $_SERVER['Shib-AuthnContext-Class'] }}
                            </td>
                        </tr>

                        <tr class="hover:bg-blue-50 even:bg-gray-50 odd:bg-white">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ __('common.shib-authentication-method') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ $_SERVER['Shib-Authentication-Method'] }}
                            </td>
                        </tr>

                        <tr class="hover:bg-blue-50 even:bg-gray-50 odd:bg-white">
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ __('common.shib-authentication-instant') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-3 text-sm">
                                {{ $_SERVER['Shib-Authentication-Instant'] }}
                            </td>
                        </tr>

                        <tr class="hover:bg-blue-50 even:bg-gray-50 odd:bg-white">
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
