@push('pre-scripts')

    <script src="/js/comments.js"></script>
@endpush

@switch($data->ref->contentType)

@case('single')

<wt-comments
    content_type="{{ $data->ref->contentType }}"
    refid="{{ $data->page->id }}"
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
    refid="{{ $data->category->id }}">
</wt-comments>

@break

@endswitch
