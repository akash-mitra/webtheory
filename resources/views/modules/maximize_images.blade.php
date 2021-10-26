<div id="image-overlay" 
    style="display: none; z-index: 10; position: fixed; left: 0; top: 0; background-color: rgba(0,0,0, 0.5); width: 100%; min-height: 100vh; height: 100%;"
    ></div>

<div id="image-holder" 
    style="display: none; z-index: 100; position: fixed; left: 0; top: 0; width: 100%; min-height: 100vh; height: 100%;"
    class="items-center justify-center" >
    <img src="#" id="maximized-image" style="max-height: 100vh; height: auto;" class="mx-auto"/>
</div>

@push('post-scripts')
    <script>
        let images = document.querySelectorAll("figure.img-fig img")
        let overlay = document.getElementById('image-overlay')
        let holder = document.getElementById('image-holder')
        let image = document.getElementById('maximized-image')
        
        let resetImage = function(event) {
            overlay.style.display = 'none'
            holder.style.display = 'none'
            image.src = '#'
            event.preventDefault();
        }

        overlay.addEventListener('click', resetImage)
        
        holder.addEventListener('click', function(event){
            if (event.target.tagName.toUpperCase() != 'IMG')
                resetImage.call(event)
        })
        
        document.body.addEventListener('keyup',function(event) {
            if (event.code == 'Escape')
                resetImage.call()
        });
        
        for (let i=0; i< images.length; i++ ) {
            images[i].classList.add('cursor-pointer')
            images[i].addEventListener('click', function (event) {
                overlay.style.display = 'block'
                holder.style.display = 'flex'
                image.src = event.target.src
            })
        }
    </script>
@endpush