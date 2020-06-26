@push('pre-scripts')

    <script src="/js/profile.js"></script>
@endpush


<wt-profile
    :profile='@json($user)'
    :show-editor="{{ $showEditor }}"
    :show-pages="{{ $showPages }}"
    user-tile-class="{{ $userTileClass }}"
    editor-tile-class="{{ $editorTileClass }}"
    pages-tile-class="{{ $pagesTileClass }}"
    link-color-class="{{ $linkColorClass }}"
></wt-profile>
