<script>
    onload = function() {
        let contentLength = document.getElementsByClassName('wt-read-time-text')[0].textContent.length
        let readingTimeEle = document.getElementById('wt-read-time-display')
        readingTimeEle.innerText = Math.ceil(contentLength / 200 / 5) + ' min Read'
    }
</script>
