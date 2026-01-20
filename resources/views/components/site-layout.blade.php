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

    <main class="min-h-102 bg-white">
        <div class="mx-auto w-2/3 pt-4">

            <div class="grid grid-cols-2 gap-6">
                <x-quote/>

                <livewire:weather-widget/>
                
            </div>

            @if($title)
                <div class="flex items-center justify-between gap-x-4">
                    <h1 class="text-3xl font-bold mb-4 text-[#26054D] shrink-0">{{$title}}</h1>
                    <hr class="w-full border-t-4 border-[#26054D] opacity-25 pb-2"/>
                </div>
            @endif

            {{$slot}}

        </div>
    </main>

    <livewire:subscription-box />

    <x-site-layout-footer/>
</body>
</html>


