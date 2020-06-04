@push('pre-scripts')

    <script src="/js/profile.js"></script>
@endpush


<wt-profile
    :profile='@json($user)'
    :show-editor="{{ $showEditor }}"
    :show-pages="{{ $showPages }}"
></wt-profile>
