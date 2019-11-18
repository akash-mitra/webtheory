@extends('backend.layout')

@section('css')
<link href="{{ mix('/css/typography.css') }}" rel="stylesheet" />
@endsection


@section ('ribbon')

<div class="flex items-center pr-1 sm:px-6 justify-between border-b">

    <div class="pl-2 lg:pr-2 flex items-center overflow-x-auto">
        <div class="uppercase text-xs px-2 sm:px-6 tracking-widest h-16 flex items-center text-white    font-semibold mr-4 bg-blue-600 shadow-inner">Contents</div>
        <div class="uppercase text-xs px-2 sm:px-6 tracking-widest h-16 flex items-center text-gray-800 font-normal   mr-4">Review</div>
        <div class="uppercase text-xs px-2 sm:px-6 tracking-widest h-16 flex items-center text-gray-800 font-normal">Analytics</div>
    </div>

    <div class="flex py-2">
        <button 
            @click="startSaving"
            type="button" 
            class="uppercase font-semibold text-xs py-3 px-4 sm:px-6 tracking-widest text-green-100 bg-green-500 rounded shadow">Save
        </button>
    </div>

</div>
@endsection



@section('main')

<div class="w-full bg-white max-h-screen px-6 overflow-y-auto">
    
    <div class="w-full mx-auto" style="max-width: 650px">

        <div class="mt-8">
            <p class="uppercase text-xs text-gray-700">Post Title</p>
            <input v-model="title" type="text" class="w-full border-b border-gray-400 py-2 text-2xl" placeholder="Once up on a time...">
        </div>
        
        <div class="mt-6">
            <p class="uppercase text-xs text-gray-700">Summary</p>
            <textarea v-model="summary" class="w-full h-40 border-b border-gray-400 py-2 text-gray-800 leading-relaxed" placeholder="Fantastic story of a Hobbit and its hole"></textarea>    
        </div>    

        <div class="mt-6">
            <p class="uppercase text-xs text-gray-700">Body</p>
        </div>

    </div>

    <div class="w-full mx-auto">
            <tensor-editor 
                :content="body" 
                ref="tensorEditor"
                v-on:data-prepare-success="sendToServer"
            ></tensor-editor>
    </div>
</div>

@endsection

@section('script')
    
    <script src="/js/editor.js"></script>

    <script>

        let data = {
            title: 'How to write an article using WebTheory Editor',
            summary: 'WebTheory platform has a very powerful and delightful editor for composing a blog post. This editor is a WYSIWYG editor, where you can instantly see how your article will look like in the actual blog page, along with various styling. We use a default styling for various writing blocks such as headings and code etc., however, these styles may be customized in the templates.',
            body: {
   "time":1574068171072,
   "blocks":[
      {
         "type":"header",
         "data":{
            "text":"Just start typing...",
            "level":4
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"To start composing a blog post, simply begin typing your first paragraph. Each paragraph is given its own block that can be individually structured as headers, or paragraphs, or lists etc. Within a line or para, you may choose to style a particular word or phrase in multiple ways. For example, if you just select a specific word, an inline styling menu will appear with options to style the selected word as <b>bold</b> or <i>italic</i>. Using this inline-styling menu, you can also <mark class=\"cdx-marker\">highlight a phrase</mark>, embed a <a href=\"https://www.google.com\">hyperlink</a> or even write some <code class=\"inline-code\">inline code</code>.&nbsp;"
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"If you like to create a new paragraph, just press enter and continue typing. Each paragraph creates a separate block and stored separately in a <code class=\"inline-code\">JSON</code> block inside the database."
         }
      },
      {
         "type":"header",
         "data":{
            "text":"Plus Tool",
            "level":5
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"When you press enter, you will notice a blue color \"plus\" button appear on the margin on the left side. This is called <b>Plus Tool</b>. When plus tool is visible, try pressing the <code class=\"inline-code\">tab</code> key on the keyboard. It will show you options to add Headings, Lists, Code Blocks, Tables and Pictures. Let's add a new heading."
         }
      },
      {
         "type":"header",
         "data":{
            "text":"6 Different Headings",
            "level":4
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"There are 6 different heading sizes available. After you choose the heading option from the Plus tool, you can specifically use one of these 6 headings by changing the headings from the right side margin&nbsp; where 3 horizontal dots appear. Just click on the dots and it will present you a menu to choose your heading of choice."
         }
      },
      {
         "type":"header",
         "data":{
            "text":"Lists",
            "level":4
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"Another important feature that you can access from the Plus Tool is - ability to add lists. There are 2 types of lists available:"
         }
      },
      {
         "type":"list",
         "data":{
            "style":"ordered",
            "items":[
               "Unordered List",
               "Ordered List"
            ]
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"After you have added a list, you can change the type of the list from the right side dots menu."
         }
      },
      {
         "type":"header",
         "data":{
            "text":"Adding Photos and Videos",
            "level":2
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"One of the finest ability of this editor is the ability to add photos and videos directly via the editor in a seamless fashion. Let us first consider various ways a&nbsp; photo can be added."
         }
      },
      {
         "type":"list",
         "data":{
            "style":"ordered",
            "items":[
               "By <b>pasting a screenshot directly</b> in the editor",
               "By <b>uploading an image</b> via plus editor",
               "By <b>pasting an URL</b> of an image (In Progress)"
            ]
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"The first option is very handy for writing tutorials or educational articles etc. where you can quickly add screenshots from your own machine in to your article."
         }
      },
      {
         "type":"image",
         "data":{
            "file":{
               "url":"/storage/media/Fs6MxfFgtrVhGgulEVZ0THdb0CYOyrW5wIZW3sS9.png"
            },
            "caption":"Screenshot from my own laptop, directly pasted in to the editor<br>",
            "withBorder":false,
            "stretched":false,
            "withBackground":false
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"When a screenshot is pasted, the editor detects that it is a media file and uploads the same to a specific laravel route <code class=\"inline-code\">Route::post('/admin/media/uploadFile', 'MediaController@upload');</code>, which then process the file and stores it under the <code class=\"inline-code\">storage/media</code> directory. Next, it sends back the URL of the uploaded file back to the editor and the editor displays the file here. <mark class=\"cdx-marker\">Therefore, if you can see the pasted screenshot in the editor, this means it has already been successfully uploaded to the server.</mark>"
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"The second option also works in the same way, only difference is that it is accessed via the the Plus Tool for uploading images which are already present in your local machine."
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"<b>A note on the 3rd option</b>"
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"The 3rd option allows you the put an image just by pasting an URL pointing to an image file (e.g., <code class=\"inline-code\">http://we.com.mk/wp-content/uploads/2017/01/zakyntos-560x250.jpg</code>). When an image url is pasted, editor detects that and send the information back to <code class=\"inline-code\">/admin/media/fetchUrl</code> route via POST method. Currently there is no handler for this route in the backend. The handler should receive the URL, download the file from the remote URL to the <code class=\"inline-code\">/storage/media</code> directory and then send back the server URL of the downloaded file to the editor. Then Editor can display the image here. The response back to the editor should be in the below format."
         }
      },
      {
         "type":"code",
         "data":{
            "code":"return [\n            \"success\" => 1, # 0 for failure\n            \"file\" => [ \"url\" => \"server url of the image\" ]\n];"
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"This needs to be done!&nbsp;"
         }
      },
      {
         "type":"header",
         "data":{
            "text":"Embedding Video",
            "level":4
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"Like photos, there is no mechanism to directly upload the video file from the editor. However, you can upload your file to YouTube, and paste the link here and the editor is intelligent enough to identify youtube link and display the video in an embedded way here. This is how it looks."
         }
      },
      {
         "type":"embed",
         "data":{
            "service":"youtube",
            "source":"https://youtu.be/41HYjV8IxiI",
            "embed":"https://www.youtube.com/embed/41HYjV8IxiI",
            "width":580,
            "height":320,
            "caption":"Video embedded by directly pasting the video URL"
         }
      },
      {
         "type":"header",
         "data":{
            "text":"Table Support",
            "level":4
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"A very simple table support is provided via the Plus Tool. It does not allow you to merge rows or columns, you can not put any inline-styles or images within the table cells. Here is an example:"
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"<b>Books I read this year</b>:"
         }
      },
      {
         "type":"table",
         "data":{
            "content":[
                ["Book","Author"],["An Auto-biography of a Yogi","Paramhansa Yogananda"],["Sapiens","Yuval Noah Harari"],["Outliers: The story of Success","Malcolm Gladwell"]
            ]
         }
      },
      {
         "type":"header",
         "data":{
            "text":"Upcoming Features",
            "level":2
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"Following features are planned,"
         }
      },
      {
         "type":"list",
         "data":{
            "style":"unordered",
            "items":[
               "Ability to embed Vimeo video",
               "Ability to embed Podcasts / Audio files",
               "Ability to attach/drag-n-drop files",
               "Ability to attach book references from Amazon",
               "And more.<br>"
            ]
         }
      },
      {
         "type":"paragraph",
         "data":{
            "text":"Enjoy!"
         }
      }
   ],
   "version":"2.15.1"
}
        };


        const app = new Vue ({
            el: '#app',
            data: data,
            methods: {
                startSaving: function () {
                    this.$refs.tensorEditor.prepareStructuredDataAndNotify();
                },

                sendToServer: function (preparedData) {
                    
                    util.ajax (
                        'post', 
                        '{{ route("api.pages.store") }}', 
                        preparedData
                    )
                }


            }
        });

    </script>
    

@endsection