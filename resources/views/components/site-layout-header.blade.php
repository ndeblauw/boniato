<header class="bg-orange-500 text-teal-50 mb-2 h-16">
    <div class="mx-auto w-2/3 flex gap-x-12 items-center justify-between">
        <div class="flex gap-x-12 items-center">
            <a href="/" class="font-semibold flex items-center gap-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 my-2" viewBox="0 0 640 640">
                    <path stroke="white" fill="white" opacity=".2" d="M112 432C112 485 155 528 208 528C228.2 528 246.9 521.8 262.3 511.2C294.1 489.3 330.2 471.3 366.6 459C396.1 449 420.1 425 428.7 392.9C440.2 350.1 465.2 308.5 497.5 278.2C516.3 260.6 527.9 235.7 527.9 208.1C527.9 155.1 484.9 112.1 431.9 112.1C405.3 112.1 381.3 122.8 363.9 140.3C333.2 171.1 295.8 199 257.8 219.8C241.7 228.6 228.4 241.9 219.6 258C198.8 296 170.9 333.3 140.1 364.1C122.6 381.5 111.9 405.5 111.9 432.1zM248 448C248 461.3 237.3 472 224 472C210.7 472 200 461.3 200 448C200 434.7 210.7 424 224 424C237.3 424 248 434.7 248 448zM280 320C280 333.3 269.3 344 256 344C242.7 344 232 333.3 232 320C232 306.7 242.7 296 256 296C269.3 296 280 306.7 280 320zM440 256C440 269.3 429.3 280 416 280C402.7 280 392 269.3 392 256C392 242.7 402.7 232 416 232C429.3 232 440 242.7 440 256z"/>
                    <path fill="#26054D" d="M528 208C528 155 485 112 432 112C405.4 112 381.4 122.7 364 140.2C333.3 171 295.9 198.9 257.9 219.7C241.8 228.5 228.5 241.8 219.7 257.9C198.9 295.9 171 333.2 140.2 364C122.7 381.4 112 405.4 112 432C112 485 155 528 208 528C228.2 528 246.9 521.8 262.3 511.2C294.1 489.3 330.2 471.3 366.6 459C396.1 449 420.1 425 428.7 392.9C440.2 350.1 465.2 308.5 497.5 278.2C516.3 260.6 527.9 235.7 527.9 208.1zM576 208C576 249.5 558.4 286.9 530.3 313.2C504.5 337.4 484.2 371.1 475.1 405.3C462.2 453.6 426.1 489.6 382 504.5C349.7 515.4 317.6 531.4 289.5 550.7C266.3 566.6 238.2 576 208 576C128.5 576 64 511.5 64 432C64 392.2 80.2 356.1 106.3 330C133.8 302.6 158.9 268.9 177.6 234.9C190.8 210.8 210.7 190.9 234.9 177.6C269 158.9 302.6 133.8 330 106.3C356.1 80.2 392.1 64 432 64C511.5 64 576 128.5 576 208zM416 232C429.3 232 440 242.7 440 256C440 269.3 429.3 280 416 280C402.7 280 392 269.3 392 256C392 242.7 402.7 232 416 232zM232 320C232 306.7 242.7 296 256 296C269.3 296 280 306.7 280 320C280 333.3 269.3 344 256 344C242.7 344 232 333.3 232 320zM224 424C237.3 424 248 434.7 248 448C248 461.3 237.3 472 224 472C210.7 472 200 461.3 200 448C200 434.7 210.7 424 224 424z"/>
                </svg>
                <span class="text-2xl">BoNiaTo</span>
            </a>

            <nav class="flex gap-x-3 pt-4">
                <a href="{{route('articles.index')}}" class="hover:bg-orange-400 hover:text-[#26054D] p-1 px-2 rounded-xl">Articles</a>
                <span class="text-[#26054D] py-1">|</span>
                <a href="{{route('categories.index')}}" class="hover:bg-orange-400 hover:text-[#26054D] p-1 px-2 rounded-xl">Categories</a>
                <span class="text-[#26054D] py-1">|</span>
                <a href="{{route('authors.index')}}" class="hover:bg-orange-400 hover:text-[#26054D] p-1 px-2 rounded-xl">Authors</a>
            </nav>
        </div>
        <div>
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 border-[#26054D] hover:bg-[#26054D] hover:text-white hover:border-[#26054D] border text-[#26054D] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 border-[#26054D] hover:bg-[#26054D] hover:text-white hover:border-[#26054D] border text-[#26054D] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>


    </div>
</header>
