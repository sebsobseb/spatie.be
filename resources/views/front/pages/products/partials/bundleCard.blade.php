<div class="mb-12 py-6 md:-mt-8 md:py-10 md:z-10 md:mb-0 md:mx-2 max-w-sm flex flex-col bg-white  shadow-lg px-8" style="bottom: -2rem">
        <span class="top-0 mt-3 left-0 absolute pl-8 pr-3 py-1 bg-green-lightest bg-opacity-50 text-green-dark text-xxs font-semibold uppercase tracking-widest">Bundle promo</span>
    <h2 class="flex-0 font-bold text-2xl leading-tight mb-4 min-h-10">
        {{ $bundle->title }}
    </h2>

    <div class="flex-grow markup markup-lists markup-lists-compact text-xs">
        <p>
            You can get a good deal when buying these products combined:
        </p>
        <ul>
            @foreach($bundle->purchasables as $purchasable)
                <li>
                @if($purchasable->product->title !== $product->title)
                <a class="font-semibold link-black link-underline" href="{{ route('products.show', $purchasable->product) }}">{{ $purchasable->product->title }}
                </a>
                @else
                <span class="font-semibold">{{ $purchasable->product->title }}</span>
                @endif

                </li>
            @endforeach
        </ul>
    </div>


    <div class="flex-0 mt-6 flex justify-center">
        <div class="w-full flex justify-center">
            <a href="{{ route('bundles.show', $bundle) }}">
                <button class="cursor-pointer
bg-green-dark bg-opacity-75 hover:bg-opacity-100 rounded-sm
border-2 border-transparent
justify-center flex items-center
px-4 min-h-12 text-xl shadow-lg
font-sans-bold text-white
transition-bg duration-300
focus:outline-none focus:border-blue-light whitespace-no-wrap">
                    <span class="font-normal">Buy Bundle for&nbsp;</span>
                    <span>{{ $bundle->getPriceForCurrentRequest()->formattedPrice() }}</span>
                </button>
            </a>
        </div>
    </div>
</div>
