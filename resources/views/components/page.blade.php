@props([
    'page',

    'hideCategoryLink' => false,
    'hideTitle' => false,
    'hideMetadata' => false,
    'hideSummary' => false,
    'hideContents' => false,
    'hideReadingTime' => false,

    'shareOptions' => null,

    'linkStyle' => '',
    'titleStyle' => '',
    'timestampStyle' => '',
    'readtimeStyle' => '',
    'summaryStyle' => '',
    'contentsStyle' => ''
])

<article {{ $attributes->merge(['class' => 'wt-typography']) }}>
    <header>
        @unless($hideCategoryLink)
            <a href="{{ $page->category->url }}" id="wt-page-category" class="{{ $linkStyle }}">
                {{ $page->category->name }}
            </a>
        @endunless

        @unless($hideTitle)
            <h1 class="{{ $titleStyle }}" id='wt-page-title'>
                {{ $page->title }}
            </h1>
        @endunless

        @unless($hideMetadata)
            <div class="w-full flex items-center mt-6 mb-8 text-sm">
                <a href="{{ $page->author->url }}">
                    <img src="{{ $page->author->avatar }}" id="wt-page-author-avatar" class="h-12 w-12 border-2 rounded-full" />
                </a>
                <div class="w-full ml-4">
                    <div class="w-full">
                        <a href="{{ $page->author->url }}" id="wt-page-author-name" class="{{ $linkStyle }}">
                            {{ $page->author->name }}
                        </a>
                    </div>
                    <div class="w-full flex items-center">
                        <div class="{{ $timestampStyle }}">
                            {{ $page->updated_at->format('M d, Y') }}
                        </div>

                        @unless($hideReadingTime)
                        <div class="{{ $readtimeStyle }}" id='wt-read-time-display'>
                            <x-page.readtime></x-page.readtime>
                        </div>
                        @endunless

                    </div>
                </div>
            </div>
        @endunless

        @unless($hideSummary)
            <div class="{{ $summaryStyle }}" id="wt-page-summary">
                {{ $page->summary }}
            </div>
        @endunless

        @if($shareOptions)
        <div class="flex mt-8">
            <x-page.share :page="$page" :options="$shareOptions"></x-page.share>
        </div>
        @endif
    </header>

    @unless($hideContents)
    <div class="{{ $contentsStyle }}" id="wt-page-contents">
        @foreach($page->contents as $content)
            <div class="mt-2 wt-read-time-text" id="wt-page-content-{{ $loop->index }}">
                {!! $content->body_html !!}
            </div>
        @endforeach
    </div>
    @endunless

</article>
