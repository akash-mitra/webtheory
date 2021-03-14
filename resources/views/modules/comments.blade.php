@push('styles')
<style>
    .grecaptcha-badge { visibility: hidden; }
</style>
@endpush

@php
    $captcha_key = json_decode(\App\Parameter::getKey('captcha_service'));
    $captcha_site_key = $captcha_key ? $captcha_key->site_key : "";
@endphp

@if($captcha_site_key != "")
    @push('pre-scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{$captcha_site_key}}"></script>
    @endpush
@endif

@push('pre-scripts')

    <script src="/js/comments.js"></script>
@endpush

@switch($data->ref->contentType)

@case('single')

<wt-comments
    content_type="{{ $data->ref->contentType }}"
    refid="{{ $data->page->id }}"
    captcha_site_key="{{ $captcha_site_key }}"
    @isset($boxClass) box-class="{{ $boxClass }}" @endisset
    @isset($textBoxClass) text-box-class="{{ $textBoxClass }}" @endisset
    @isset($buttonClass) button-class="{{ $buttonClass }}" @endisset
    @isset($linkClass) link-class="{{ $linkClass }}" @endisset
    @isset($commentClass) comment-class="{{ $commentClass }}" @endisset
    @isset($textClass) text-class="{{ $textClass }}" @endisset
    @isset($commentInviteClass) comment-invite-class="{{ $commentInviteClass }}" @endisset
    >
</wt-comments>

@break


@case('category')

<wt-comments
    content_type="{{ $data->ref->contentType }}"
    refid="{{ $data->category->id }}"
    captcha_site_key="{{ $captcha_site_key }}"
    >
    
</wt-comments>

@break

@endswitch
