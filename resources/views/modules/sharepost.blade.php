
@if(optional($data->ref->share)->facebook_share === 'On')
    <a href="{{ $data->page->getShareUrl() }}" target="_blank" rel="noopener" class="mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 512 512"><rect width="512" height="512" rx="15%" fill="#1877f2"/><path d="M355.6 330l11.4-74h-71v-48c0-20.2 9.9-40 41.7-40H370v-63s-29.3-5-57.3-5c-58.5 0-96.7 35.4-96.7 99.6V256h-65v74h65v182h80V330h59.6z" fill="#fff"/></svg>
    </a>
@endif

@if(optional($data->ref->share)->twitter_post === 'On')
<a href="{{ $data->page->getShareUrl('twitter') }}" target="_blank" rel="noopener" class="mr-4">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 512 512"><rect width="512" height="512" rx="15%" fill="#1da1f3"/><path fill="#fff" d="M437 152a72 72 0 0 1-40 12 72 72 0 0 0 32-40 72 72 0 0 1-45 17 72 72 0 0 0-122 65 200 200 0 0 1-145-74 72 72 0 0 0 22 94 72 72 0 0 1-32-7 72 72 0 0 0 56 69 72 72 0 0 1-32 1 72 72 0 0 0 67 50 200 200 0 0 1-105 29 200 200 0 0 0 309-179 200 200 0 0 0 35-37"/></svg>
</a>
@endif

@if(optional($data->ref->share)->linkedin_post === 'On')
<a href="{{ $data->page->getShareUrl('linkedin') }}" target="_blank" rel="noopener" class="mr-4">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 512 512" fill="#fff"><rect width="512" height="512" rx="15%" fill="#0077b5"/><circle cx="142" cy="138" r="37"/><path stroke="#fff" stroke-width="66" d="M244 194v198M142 194v198"/><path d="M276 282c0-20 13-40 36-40 24 0 33 18 33 45v105h66V279c0-61-32-89-76-89-34 0-51 19-59 32"/></svg>
</a>
@endif

@if(optional($data->ref->share)->pinterest_pin === 'On')
<a href="{{ $data->page->getShareUrl('pinterest') }}" target="_blank" rel="noopener" class="mr-4">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 512 512"><rect width="512" height="512" rx="15%" fill="#bd081b"/><path d="m265 65c-104 0-157 75-157 138 0 37 14 71 45 83 5 2 10 0 12-5l3-18c2-6 1-7-2-12-9-11-15-24-15-43 0-56 41-106 108-106 60 0 92 37 92 85 0 64-28 116-70 116-23 0-40-18-34-42 6-27 19-57 19-77 0-18-9-34-30-34-24 0-42 25-42 58 0 20 7 34 7 34l-29 120a249 249 0 0 0 2 86l3-1c2-3 31-37 40-72l16-61c7 15 29 28 53 28 71 0 119-64 119-151 0-66-56-126-140-126z" fill="#fff"/></svg>
</a>
@endif

@if(optional($data->ref->share)->whatsapp_send === 'On')
<a href="{{ $data->page->getShareUrl('whatsapp') }}" target="_blank" rel="noopener" class="mr-4">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 512 512" fill="#fff"><rect width="512" height="512" rx="15%" fill="#45d354"/><path d="M308 273c-3-2-6-3-9 1l-12 16c-3 2-5 3-9 1-15-8-36-17-54-47-1-4 1-6 3-8l9-14c2-2 1-4 0-6l-12-29c-3-8-6-7-9-7h-8c-2 0-6 1-10 5-22 22-13 53 3 73 3 4 23 40 66 59 32 14 39 12 48 10 11-1 22-10 27-19 1-3 6-16 2-18"/><path d="M264 384c-41 0-72-22-72-22l-49 13 12-48s-20-31-20-70c0-72 59-132 132-132 68 0 126 53 126 127 0 72-58 131-129 132m-159 29l83-23a158 158 0 0 0 230-140c0-86-68-155-154-155a158 158 0 0 0-137 236"/></svg>
</a>
@endif
