@push('pre-scripts')

    <script src="/js/comments.js"></script>
@endpush

<wt-comments content="{{ $data->page->id }}"></wt-comments>