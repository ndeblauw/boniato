<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="white">
<header class="bg-teal-500 text-teal-50 mb-2">
    <div class="mx-auto w-2/3">
        menu
    </div>
</header>
<main>
    <div class="mx-auto w-2/3">
        <div>
            <h1 class="text-3xl font-bold mb-4 bg-teal-100">{{$title}}</h1>
        </div>

        {{$slot}}
    </div>
</main>
<footer class="bg-teal-100 mt-10 h-20">
    <div class="mx-auto w-2/3">
        some really important legal stuff
    </div>

</footer>
</body>
</html>


