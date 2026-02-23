<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @section('title', "Error")
    </head>
    <body class="antialiased">
        <main class="relative flex justify-center min-h-screen bg-emerald-50 dark:bg-zinc-800 items-center sm:pt-0"
             role="main">
            <div class="mx-auto flex w-full max-w-7xl grow flex-col justify-center px-6 lg:px-8">
                <div class="flex shrink-0 justify-center">
                    <a href="/" class="inline-flex">
                        <span class="sr-only">Bud</span>
                        <x-public.mark class="h-20 w-auto"/>
                    </a>
                </div>
                <div class="py-16">
                    <div class="text-center">
                        <p class="text-base font-semibold text-emerald-600 dark:text-emerald-400">
                            @yield('code')
                        </p>
                        <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-emerald-950/90 sm:text-7xl dark:text-emerald-50">
                            @yield('message')
                        </h1>
                        <div class="mt-6">
                            <div class="mt-10 flex items-center justify-center gap-x-6">
                                <a href="/"
                                   class="rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white dark:text-emerald-900 shadow-xs hover:bg-emerald-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:focus-visible:outline-emerald-500">Go
                                    back home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </body>
</html>
