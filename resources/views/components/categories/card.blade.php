@props(['category'])
<!-- Category Card -->

<a href="#">
    <div class="relative cursor-pointer">
        <img class="mx-auto max-h-60 w-full brightness-50 duration-300 hover:brightness-100"
            src="{{ asset('storage/'.$category->image) }}"
            alt=" {{ $category->name }}"
        />

        <p class="pointer-events-none absolute top-1/2 left-1/2 w-11/12 -translate-x-1/2 -translate-y-1/2 text-center text-white lg:text-xl" >
            {{ $category->name }}
        </p>
    </div>
</a>
