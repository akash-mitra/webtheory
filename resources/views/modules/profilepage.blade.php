@push('pre-scripts')

    <script src="/js/profile.js"></script>
@endpush


<wt-profile
    :profile='@json($user)'
    :show-editor="{{ $showEditor }}"
    :show-pages="{{ $showPages }}"
    text-color-class="text-{{$data->ref->template->primaryColor}}-100"
></wt-profile>
