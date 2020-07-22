<span id='wt_read_timer'></span>

@push('post-scripts')
<script>

    let contentLength = document.getElementsByClassName('wt-body')[0].textContent.length
    let readingTimeEle = document.getElementById('wt_read_timer')

    readingTimeEle.innerText = Math.ceil(contentLength / 200 / 5) + ' min Read'
</script>
@endpush