@props([
    'logoText' => 'Blog',
    'logoFile',
    'color' => 'blue',
])

<a href="/" {{ $attributes }}>
    @empty($logoFile)
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current text-{{ $color }}-600 inline-block fill-current h-12 w-12" id="wt-logo-icon" viewBox="0 0 512 512">
            <path d="M147 286a10 10 0 100 20 10 10 0 000-20zM147 326c-6 0-10 4-10 10v126a10 10 0 1020 0V336c0-6-5-10-10-10z"/>
            <path d="M424 8a10 10 0 00-15-6c-10 7-61 45-69 67-5 14-4 28 3 41-12 17-25 42-36 65V10c0-6-5-10-10-10h-80c-6 0-10 4-10 10v196h-2l-17-66v-1l-16-57v-1-1l-1-1a10 10 0 00-1-1L111 8a10 10 0 00-17 4l-18 91-1 1a10 10 0 001 2v1l15 58 11 41a30 30 0 00-25 30c0 13 8 24 20 28v198c0 28 22 50 50 50h200c27 0 50-22 50-50V264a30 30 0 0020-28c0-15-11-27-25-29 7-27 12-53 13-74 14-5 24-16 29-29 8-23-7-84-10-96zm-68 118a50 50 0 0029 10c-2 20-7 45-13 70h-57c15-35 29-62 41-80zM227 20h60v23h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v23h-60V20zM109 36l41 49a46 46 0 01-53 14l12-63zm-9 85a66 66 0 0058-16l11 40 15 61h-62l-11-46-11-39zm277 341c0 17-14 30-30 30H147c-17 0-30-13-30-30V266h260v196zm20-226a10 10 0 01-10 10H107a10 10 0 010-20h280c5 0 10 4 10 10zm18-139a30 30 0 01-52 7c-6-8-7-18-4-28 4-10 28-32 49-49 6 27 11 59 7 70z"/>
        </svg>
    @else
        <img src="{{ $logoFile }}" alt="Logo" class="h-12 w-12" id="wt-logo-icon" />
    @endempty

    <span class="pl-2 cursor-pointer text-2xl md:text-3xl font-bold text-{{ $color }}-600 opacity-75" id="wt-logo-text">
        {{ $logoText }}
    </span>
</a>

