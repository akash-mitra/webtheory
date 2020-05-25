@push('pre-scripts')

    <script async defer crossorigin="anonymous" src={{ "https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0&appId=" . $data->ref->comment->facebook_client_id . "&autoLogAppEvents=1" }}></script>
@endpush

<div id="fb-root"></div>
<h4 class="text-md text-blue-800 mt-8">Facebook Comments</h4>
<div class="fb-comments" data-href={{ Request::url() }} data-numposts="5" data-width="100%"></div>
