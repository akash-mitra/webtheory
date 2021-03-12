<div class="w-full">
    @php
        $ad_services = json_decode(\App\Parameter::getKey('ad_services'));
        $adsense_id = $ad_services ? $ad_services->adsense_id : "";
    @endphp

    @if($adsense_id != "")
        @push('post-scripts')
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <ins class="adsbygoogle"
                style="display: block;"
                data-ad-client="{{ $adsense_id }}"
                data-ad-format="auto"
                data-full-width-responsive="false"
            ></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        @endpush
    @endif
</div>