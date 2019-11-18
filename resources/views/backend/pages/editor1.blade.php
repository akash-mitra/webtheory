@extends('backend.layout')



@section('main')


    <div class="w-full p-4 flex items-center bg-white border-b"> 
        <h3 class="w-full max-w-3xl mx-auto ">Summary</h3>
    </div>
    <div class="w-full p-4 flex items-center bg-white border-b"> 
        <h3 class="w-full max-w-3xl mx-auto ">Contents</h3>
    </div>
    
    <div class="px-6 md:px-4 lg:pl-2 lg:pr-4 py-3 max-w-3xl mx-auto bg-white bor1der shadow-xl roun1ded-lg">
        <tensor-editor></tensor-editor>
    </div>

    <div class="w-full p-4 flex items-center bg-white border-b border-t"> 
        <h3 class="w-full max-w-3xl mx-auto ">Meta</h3>
    </div>

@endsection

@section('script')
    
    <script src="/js/editor.js"></script>

    <script>

        const app = new Vue ({
            el: '#app',
        });

    </script>
    

@endsection