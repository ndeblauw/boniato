<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="MyWebSite" />
    <link rel="manifest" href="/site.webmanifest" />
</head>
<body class="white">

    <x-site-layout-header/>

    <main class="min-h-[25.5rem] bg-white">
        <div class="mx-auto w-2/3 pt-4">

            <livewire:weather-widget/>

            @if($title)
                <div class="bg-[repeating-linear-gradient(45deg,rgba(147,51,234,0.95)_0,rgba(147,51,234,0.95)_10px,transparent_10px,transparent_20px)] h-2">
                    &nbsp;
                </div>

                <div class="bg-purple-600 text-white p-4 mb-6 ">
                    <h1 class="text-3xl font-bold">{{$title}}</h1>
                </div>
            @endif

            {{$slot}}

        </div>
    </main>

    <livewire:subscription-box />

    <x-site-layout-footer/>
</body>
</html>


