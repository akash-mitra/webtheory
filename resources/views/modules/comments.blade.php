@push('pre-scripts')

    <script src="/js/comments.js"></script>
@endpush

@switch($data->ref->contentType)

@case('single')

<wt-comments
    content_type="{{ $data->ref->contentType }}"
    refid="{{ $data->page->id }}">
</wt-comments>

@break


@case('category')

<wt-comments
    content_type="{{ $data->ref->contentType }}"
    refid="{{ $data->category->id }}">
</wt-comments>

@break

@endswitch
