<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />


{{--Meta--}}
<title>@yield('title', config('app.name'))</title>
<meta name="description"
      content="@yield('description', 'Bud is a simple boilerplate for quickly building Laravel applications')"/>
<meta property="og:image" content="{{ url('assets/images/core/ogimage.jpg') }}">
<meta property="og:title" content="@yield('og:title', "Bud - Laravel Boilerplate"))">

<meta name="keywords" content="@yield('keywords', 'Bud')"/>

{{--Icons--}}
<link rel="icon" type="image/png" href="/assets/images/core/favicon-96x96.png" sizes="96x96"/>
<link rel="icon" type="image/svg+xml" href="/assets/images/core/favicon.svg"/>
<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/core/apple-touch-icon.png"/>
<meta name="apple-mobile-web-app-title" content="Bud"/>
<link rel="manifest" href="/assets/images/core/site.webmanifest"/>

<link rel="canonical" href="{{ request()->fullUrl() }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
