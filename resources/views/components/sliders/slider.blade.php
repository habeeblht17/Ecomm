<!-- Slider main container -->
<div class="swiper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        @foreach ($sliders as $slider)
            <!-- Slides -->
            <div class="swiper-slide">
                <!-- Banner -->
                <img class="w-full object-cover brightness-80 filter lg:h-[500px]"
                src="{{ asset('storage/'.$slider->banner) }}" alt="{{ $slider->name }}" />

                <!-- Banner Content -->
                <div class="absolute z-10 top-1/2 left-1/2 mx-auto flex w-11/12 max-w-[1200px] -translate-x-1/2 -translate-y-1/2 flex-col text-center text-white lg:ml-5">
                    <h1 class="text-4xl font-bold sm:text-5xl lg:text-left">
                        {{ $slider->type }}
                    </h1>
                    <p class="pt-3 text-xs lg:w-3/5 lg:pt-4 lg:text-left lg:text-base">
                        {{ $slider->description }}
                    </p>
                    <h6 class="pt-3 text-xl lg:w-3/5 lg:pt-4 lg:text-left ">Start at ${{$slider->starting_price}}</h6>
                    <button class="w-1/2 px-3 py-1 mx-auto mt-5 text-black duration-100 bg-amber-400 hover:bg-yellow-300 lg:mx-0 lg:h-10 lg:w-2/12 lg:px-10">
                        <a class="" href="{{$slider->btn_url}}">Shop Now</a>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- If we need navigation buttons -->
    {{-- prev --}}
    <div class="absolute z-10 p-2 cursor-pointer swiper-button-prev top-1/2">
        <div class="p-1 border rounded-full bg-white/60 text-purple-950">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.8" stroke="currentColor" class="w-4 h-4">
                <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </div>
    </div>

    {{-- next --}}
    <div class="absolute right-0 z-10 p-2 cursor-pointer swiper-button-next top-1/2">
        <div class="p-1 border rounded-full bg-white/60 text-purple-950">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.8" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </div>
    </div>
</div>
