<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('assets/css/tailwind-ecommerce.css') }}" />

        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-touch-icon.png') }}" />
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}" />
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}" />

        <link rel="manifest" href="{{ asset('site.webmanifest') }}" />
        <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#207891" />
        <meta name="msapplication-TileColor" content="#ffc40d" />
        <meta name="theme-color" content="#ffffff" />

        <title>{{ config('app.name', 'LHT - Online store') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!--custom styles-->
        <style>
            .swiper-wrapper {
                transition-timing-function: linear;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body x-data="{ desktopMenuOpen: false, mobileMenuOpen: false}">
        <!-- Header -->
        <header class="mx-auto flex h-16 max-w-[1200px] items-center justify-between px-5">
            <a href="{{ route('home') }}">
                <img class="cursor-pointer w-24 h-24" src="{{ asset('logo/lht.png') }}"  alt="company logo"/>
            </a>

            <div class="md:hidden">
                <button @click="mobileMenuOpen = ! mobileMenuOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
            </div>

            <form class="items-center hidden w-2/5 border h-9 md:flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-9 mx-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>

                <input class="hidden w-11/12 h-9 outline-none border-gray-200 md:block" type="search" placeholder="Search"/>

                <button class="h-9 px-4 ml-auto bg-amber-400 hover:bg-yellow-300">
                    Search
                </button>
            </form>

            <div class="hidden gap-3 md:!flex">
                <a href={{ route('wishlist') }}" class="flex flex-col items-center justify-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                    <p class="text-xs">Wishlist</p>
                </a>

                <a href="{{ route('cart') }}" class="flex flex-col items-center justify-center cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z"
                            clip-rule="evenodd"
                        />
                    </svg>

                    <p class="text-xs">Cart</p>
                </a>

                @auth
                    <a href="{{ route('my-account') }}" class="relative flex flex-col items-center justify-center cursor-pointer">
                        <span class="absolute bottom-[33px] right-1 flex h-2 w-2">
                            <span class="absolute inline-flex w-full h-full bg-red-400 rounded-full opacity-75 animate-ping"></span>
                            <span class="relative inline-flex w-2 h-2 bg-red-500 rounded-full"></span>
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>

                        <p class="text-xs">Account</p>
                    </a>
                @endauth
            </div>
        </header>
        <!-- /Header -->

        <!-- Hanburger menu  -->
        <section x-show="mobileMenuOpen" @click.outside="mobileMenuOpen = false"
            class="absolute left-0 right-0 z-50 w-full h-screen bg-white" style="display: none">
            <div class="mx-auto">
                <div class="flex justify-center w-full gap-3 py-4 mx-auto">
                    <a href="{{ route('wishlist') }}" class="flex flex-col items-center justify-center cursor-pointer" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                        </svg>

                        <p class="text-xs">Wishlist</p>
                    </a>

                    <a href="{{ route('cart') }}" class="flex flex-col items-center justify-center cursor-pointer">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="w-6 h-6">
                            <path fill-rule="evenodd"  d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z" clip-rule="evenodd"/>
                        </svg>

                        <p class="text-xs">Cart</p>
                    </a>

                    @auth
                        <a href="{{ route('my-account') }}" class="relative flex flex-col items-center justify-center cursor-pointer">
                            <span class="absolute bottom-[33px] right-1 flex h-2 w-2">
                                <span class="absolute inline-flex w-full h-full bg-red-400 rounded-full opacity-75 animate-ping"></span>
                                <span class="relative inline-flex w-2 h-2 bg-red-500 rounded-full"></span>
                            </span>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                />
                            </svg>

                            <p class="text-xs">Account</p>
                        </a>
                    @endauth
                </div>

                <form class="flex items-center mx-5 my-4 border h-9">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-4 h-4 mx-3"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                        />
                    </svg>

                    <input class="hidden w-11/12 h-9 outline-none md:block" type="search" placeholder="Search"/>

                    <button type="submit" class="h-9 px-4 ml-auto bg-amber-400 hover:bg-yellow-300">
                        Search
                    </button>
                </form>

                <ul class="font-medium text-center">
                    <li class="py-2"><a href="{{ route('home') }}">Home</a></li>
                    <li class="py-2"><a href="{{ route('catalog') }}">Catalog</a></li>
                    <li class="py-2"><a href="{{ route('about-us') }}">About Us</a></li>
                    <li class="py-2"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                </ul>
            </div>
        </section>
        <!-- /Burger menu  -->

        <!-- Nav bar -->
        <!-- hidden on small devices -->
        <nav class="relative bg-violet-900">
            <div class="mx-auto hidden h-12 w-full max-w-[1200px] items-center md:flex">
                <button @click="desktopMenuOpen = ! desktopMenuOpen"
                    class="flex items-center justify-center w-40 h-full ml-5 cursor-pointer bg-amber-400">
                    <div class="flex justify-around" href="#">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6 mx-1">
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                            />
                        </svg>

                        All categories
                    </div>
                </button>

                <div class="flex gap-8 mx-7">
                    <a  href="{{ route('home') }}" class="font-light text-white duration-100 hover:text-yellow-400 hover:underline">Home</a>
                    <a  href="{{ route('catalog') }}" class="font-light text-white duration-100 hover:text-yellow-400 hover:underline">Catalog</a>
                    <a  href="{{ route('about-us') }}" class="font-light text-white duration-100 hover:text-yellow-400 hover:underline">About Us</a>
                    <a href="{{ route('contact-us') }}" class="font-light text-white duration-100 hover:text-yellow-400 hover:underline">Contact Us</a>
                </div>

                <div class="ml-auto ">
                    @if (Route::has('login'))
                        <div class="flex gap-4 px-5">
                            @auth
                                <a href="{{ route('my-account') }}" class="font-light text-white duration-100 hover:text-yellow-400 hover:underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="font-light text-white duration-100 hover:text-yellow-400 hover:underline">Log in</a>

                                <span class="text-white">&#124;</span>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="font-light text-white duration-100 hover:text-yellow-400 hover:underline">Sign Up</a>
                                @endif
                            @endauth
                        </div>
                    @endif

                </div>
            </div>
        </nav>
        <!-- /Nav bar -->

        <!-- Menu  -->
        <section x-show="desktopMenuOpen" @click.outside="desktopMenuOpen = false"
            class="absolute left-0 right-0 z-10 w-full bg-white border-b border-l border-r"
            style="display: none">
            <div class="mx-auto flex max-w-[1200px] py-10">
                <div class="w-[300px] border-r">
                    <ul class="px-5">
                    <li class="flex items-center gap-2 px-3 py-2 active:blue-900 bg-amber-400 active:bg-amber-400">
                        <img width="15px" height="15px" src="{{ asset('assets/images/bed.svg') }}" alt="Bedroom icon"/>
                        Bedroom
                        <span class="ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-4 h-4">
                                <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </span>
                    </li>

                    <li class="flex items-center gap-2 px-3 py-2 active:blue-900 hover:bg-neutral-100 active:bg-amber-400"
                    >
                        <img width="15px" height="15px" src="{{ asset('assets/images/sleep.svg') }}" alt="bedroom icon" />
                        Matrass
                        <span class="ml-auto">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-4 h-4">
                                <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                />
                            </svg>
                        </span>
                    </li>

                    <li
                        class="flex items-center gap-2 px-3 py-2 active:blue-900 hover:bg-neutral-100 active:bg-amber-400"
                    >
                        <img
                        width="15px"
                        height="15px"
                        src="./assets/images/outdoor.svg"
                        alt="bedroom icon"
                        />
                        Outdoor
                        <span class="ml-auto"
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                        </span>
                    </li>

                    <li
                        class="flex items-center gap-2 px-3 py-2 active:blue-900 hover:bg-neutral-100 active:bg-amber-400"
                    >
                        <img
                        width="15px"
                        height="15px"
                        src="./assets/images/sofa.svg"
                        alt="bedroom icon"
                        />
                        Sofa
                        <span class="ml-auto"
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                        </span>
                    </li>

                    <li
                        class="flex items-center gap-2 px-3 py-2 active:blue-900 hover:bg-neutral-100 active:bg-amber-400"
                    >
                        <img
                        width="15px"
                        height="15px"
                        src="./assets/images/kitchen.svg"
                        alt="bedroom icon"
                        />
                        Kitchen
                        <span class="ml-auto"
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                        </span>
                    </li>

                    <li
                        class="flex items-center gap-2 px-3 py-2 active:blue-900 hover:bg-neutral-100 active:bg-amber-400"
                    >
                        <img
                        width="15px"
                        height="15px"
                        src="./assets/images/food.svg"
                        alt="Food icon"
                        />
                        Living room
                        <span class="ml-auto"
                        ><svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-4 h-4"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 4.5l7.5 7.5-7.5 7.5"
                            />
                        </svg>
                        </span>
                    </li>
                    </ul>
                </div>

                <div class="flex justify-between w-full">
                    <div class="flex gap-6">
                        <div class="mx-5">
                            <p class="font-medium text-gray-500">BEDS</p>
                            <ul class="text-sm leading-8">
                            <li><a href="product-overview.html">Italian bed</a></li>
                            <li><a href="product-overview.html">Queen-size bed</a></li>
                            <li><a href="product-overview.html">Wooden craft bed</a></li>
                            <li><a href="product-overview.html">King-size bed</a></li>
                            </ul>
                        </div>

                        <div class="mx-5">
                            <p class="font-medium text-gray-500">LAMPS</p>
                            <ul class="text-sm leading-8">
                            <li><a href="product-overview.html">Italian Purple Lamp</a></li>
                            <li><a href="product-overview.html">APEX Lamp</a></li>
                            <li><a href="product-overview.html">PIXAR lamp</a></li>
                            <li><a href="product-overview.html">Ambient Nightlamp</a></li>
                            </ul>
                        </div>

                        <div class="mx-5">
                            <p class="font-medium text-gray-500">BEDSIDE TABLES</p>
                            <ul class="text-sm leading-8">
                            <li><a href="product-overview.html">Purple Table</a></li>
                            <li><a href="product-overview.html">Easy Bedside</a></li>
                            <li><a href="product-overview.html">Soft Table</a></li>
                            <li><a href="product-overview.html">Craft Table</a></li>
                            </ul>
                        </div>

                        <div class="mx-5">
                            <p class="font-medium text-gray-500">SPECIAL</p>
                            <ul class="text-sm leading-8">
                            <li><a href="product-overview.html">Humidifier</a></li>
                            <li><a href="product-overview.html">Bed Cleaner</a></li>
                            <li><a href="product-overview.html">Vacuum Cleaner</a></li>
                            <li><a href="product-overview.html">Pillow</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Menu  -->

        <div class="">
            {{ $slot }}
        </div>

        <!-- Desktop Footer  -->
        <footer class="mx-auto w-full max-w-[1200px] justify-between pb-10 flex flex-col lg:flex-row">
            <div class="ml-5">
                <a href="{{ route('home') }}">
                    <img class="cursor-pointer w-24 h-24" src="{{ asset('logo/lht.png') }}"  alt="company logo"/>
                </a>

                <p class="pl-0">
                    Lorem ipsum dolor sit amet consectetur <br />
                    adipisicing elit.
                </p>
                <div class="flex gap-3 mt-10">
                    <a href="https://github.com/bbulakh">
                    <img
                        class="w-5 h-5 cursor-pointer"
                        src="./assets/images/github.svg"
                        alt="github icon"
                    />
                    </a>
                    <a href="https://t.me/b_bulakh">
                    <img
                        class="w-5 h-5 cursor-pointer"
                        src="./assets/images/telegram.svg"
                        alt="telegram icon"
                    />
                    </a>
                    <a href="https://www.linkedin.com/in/bogdan-bulakh-393284190/">
                    <img
                        class="w-5 h-5 cursor-pointer"
                        src="./assets/images/linkedin.svg"
                        alt="twitter icon"
                    />
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 md:grid-cols-4">
                <div class="mx-5 mt-10">
                    <p class="font-medium text-gray-500">FEATURES</p>
                    <ul class="text-sm leading-8">
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Commerce</a></li>
                    <li><a href="#">Analytics</a></li>
                    <li><a href="#">Merchendise</a></li>
                    </ul>
                </div>

                <div class="mx-5 mt-10">
                    <p class="font-medium text-gray-500">SUPPORT</p>
                    <ul class="text-sm leading-8">
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Docs</a></li>
                    <li><a href="#">Audition</a></li>
                    <li><a href="#">Art Status</a></li>
                    </ul>
                </div>

                <div class="mx-5 mt-10">
                    <p class="font-medium text-gray-500">DOCUMENTS</p>
                    <ul class="text-sm leading-8">
                    <li><a href="#">Terms</a></li>
                    <li><a href="#">Conditions</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">License</a></li>
                    </ul>
                </div>

                <div class="mx-5 mt-10">
                    <p class="font-medium text-gray-500">DELIVERY</p>
                    <ul class="text-sm leading-8">
                    <li><a href="#">List of countries</a></li>
                    <li><a href="#">Special information</a></li>
                    <li><a href="#">Restrictions</a></li>
                    <li><a href="#">Payment</a></li>
                    </ul>
                </div>
            </div>
        </footer>
        <!-- /Desktop Footer  -->

        <!-- Payment and copyright  -->
        <section class="h-11 bg-amber-400">
            <div
            class="mx-auto flex max-w-[1200px] items-center justify-between px-4 pt-2"
            >
            <p>&copy; Bogdan Bulakh, 2023</p>
            <div class="flex items-center space-x-3">
                <img
                class="h-8"
                src="https://cdn-icons-png.flaticon.com/512/5968/5968299.png"
                alt="Visa icon"
                />
                <img
                class="h-8"
                src="https://cdn-icons-png.flaticon.com/512/349/349228.png"
                alt="AE icon"
                />

                <img class="h-8" src="https://cdn-icons-png.flaticon.com/512/5968/5968144.png" alt="Apple pay icon"/>
            </div>
            </div>
        </section>
        <!-- /Payment and copyright  -->

        @livewireScripts

        <script type="module" src="{{ asset('assets/js/script.js') }}"></script>
    </body>
</html>
