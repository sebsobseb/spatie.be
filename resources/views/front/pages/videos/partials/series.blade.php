<section id="series" class="section overflow-visible">
    <div class="wrap grid sm:grid-cols-2 col-gap-24 row-gap-24 | markup-lists">
        @foreach($allSeries as $series)
            <div>

                    <div class="h-full my-6">
                        <h2 class="title-sm">
                            <div class="-mt-8 pb-6">
                                <div class="shadow-lg">
                                    <a href="{{ $series->url }}">{{ $series->getFirstMedia('series-image') }}</a>
                                </div>
                            </div>
                            <a class="link-black link-underline-hover" href="{{ $series->url }}">{{ $series->title }}</a>
                            <div class="title-subtext text-gray flex items-center">
                                <span>
                                {{ $series->videos()->count() }}
                                {{  \Illuminate\Support\Str::plural('video', $series->videos()->count()) }}
                                </span>

                                @if($series->isPurchasable())
                                    <span title="Part of course" class="ml-1 w-4 h-4 inline-flex items-center justify-center bg-green-lightest rounded-full">
                                    <span style="font-size: .6rem; top: -.1rem" class="icon text-green">
                                        @if ($series->isOwnedByCurrentUser())
                                            {{ svg('icons/fas-lock-open-alt') }}
                                        @else
                                            {{ svg('icons/fas-lock-alt') }}
                                        @endif
                                    </span>
                                </span>
                                @else
                                    @if($series->hasSponsoredContent())
                                        <span title="Series has extra content for sponsors" class="ml-1 w-4 h-4 inline-flex items-center justify-center bg-pink-lightest rounded-full">
                                            <span style="font-size: .6rem" class="icon text-pink">
                                                {{ svg('icons/fas-heart') }}
                                            </span>
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </h2>

                        <p class="my-4 flex items-center space-x-4">
                         @if($series->isPurchasable())
                            @if (! $series->isOwnedByCurrentUser())
                                <a href="{{ $series->purchaseLink() }}">
                                    <x-button>
                                        Buy course
                                    </x-button>
                                </a>
                                @if ($videoUrl = $series->sampleVideoUrl())
                                    <a class="link-underline link-blue" href="{{ $videoUrl }}">Watch sample</a>
                                @endif
                            @else
                                    <a href="{{ $series->url }}">
                                    <x-button>
                                        Start course
                                    </x-button>
                                    </a>
                            @endif
                         @else
                            <a class="link-underline link-blue" href="{{ $series->url }}">Watch {{  \Illuminate\Support\Str::plural('videos', $series->videos()->count()) }}</a>
                        @endif
                        </p>

                        <p class="mt-4">
                            {{ $series->formattedDescription }}
                        </p>

                    </div>

            </div>
        @endforeach
    </div>
</section>
