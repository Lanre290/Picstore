@include('includes.header-script', ['url' => 'The wedding party'])

<body>
    @include('includes.topnav')

    <div class="fixed top-10 right-0 left-0 flex flex-col pt-10">
        <div class="flex flex-col md:flex-row w-full">
            <div class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500 relative">
                <h3 class="text-center">Upload picture</h3>
                <input type="file" name="" id="post_input" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" multiple>
            </div>
            <button class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer px-4 py-3 text-center text-gray-50 ml-3 hover:bg-blue-500">
                Reset Link
            </button>
            <button class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer text-center px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500" data-link='' onclick="copyEventLink(this)">
                Copy Event Link <i class="fa fa-link"></i>
            </button>
        </div>

        <div class="w-full border-t border-gray-300 mt-3 flex content-start justify-start flex-wrap h-screen overflow-y-scroll pb-56">
            <div class="w-full mm:w-1/3 md:w-1/4 lg:w-1/5 xl:w-1/6 h-52 cursor-pointer relative border border-gray" onclick="showImageFullScreen(this, event)">
                <img src="{{asset('img/favicon.png')}}" alt="" class="w-full h-full object-cover" id="image">
                <a href={{asset('img/favicon.png')}} class="absolute bottom-1 right-1 bg-transparent text-3xl text-gray-500 hover:bg-gray-300 p-3 hover:bg-opacity-50" onclick="stopPropagation(event)" download>
                    <i class="fa fa-download"></i>
                </a>
            </div>
            
        </div>
        
    </div>

    <div class="fixed top-0 bottom-0 right-0 left-0 bg-black bg-opacity-50 flex items-center justify-center z-40" style="display: none;" id="upload_images">
        <div class="w-full h-full md:w-4/5 md:h-4/5 z-50 bg-gray-50 p-2 md:p-10">
            <div class="flex flex-col-reverse md:flex-row justify-between">
                <div class="flex flex-col md:flex-row">
                    <button class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer text-center px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500">
                        Upload Pictures
                    </button>
                    <div class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500 relative">
                        <h3 class="text-center">Add Pictures</h3>
                        <input type="file" name="" id="post_input_2" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" multiple>
                    </div>
                </div>
                <button class="text-gray-900 m-5 md:m-0 cursor-pointer text-2xl h-12 w-12 flex items-center justify-center p-4 hover:bg-gray-200 rounded-full hover:bg-opacity-50" onclick="closeUploadImage()">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <div class="w-full mt-3 flex content-start justify-start flex-wrap overflow-y-auto h-4/5" id="post_images_div">
                {{-- <div class="w-1/2 mm:w-1/3 md:w-1/4 h-52 cursor-pointer relative m-1">
                    <img src="{{asset('img/favicon.png')}}" alt="" class="w-full h-full object-cover">
                    <button class="text-gray-900 cursor-pointer text-2xl h-12 w-12 flex items-center justify-center p-4 hover:bg-gray-200 rounded-full hover:bg-opacity-50 absolute top-2 right-2">
                        <i class="fa fa-close"></i>
                    </button>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="fixed top-0 bottom-0 right-0 left-0 bg-black bg-opacity-90 flex items-center justify-center z-40" style="display: none;" id="image_fs_cont">
        <img src="" id="image_fs" alt="" class="w-full md:w-auto md:h-4/5 object-cover z-20">
        <button class="cursor-pointer text-5xl md:text-7xl text-gray-50 h-24 w-24 flex items-center justify-center p-4 hover:bg-gray-200 rounded-full hover:bg-opacity-50 absolute top-2 right-2 z-50" onclick="closeImageFs()">
            <i class="fa fa-close"></i>
        </button>
    </div>

</body>




<script>

    let postImages = [];

    function removeImage(name, element, event){
        event.stopPropagation();
        element.parentElement.style.display = 'none';
        let index = postImages.findIndex(fileObj => fileObj.name === name)
        postImages.splice(index, 1);

        console.log(postImages);
    }

    function  putPictures(){
        let arr = [...document.getElementById('post_input').files, ...document.getElementById('post_input_2').files];
        document.getElementById('upload_images').style.display = 'flex';

        try {
            for (let index = 0; index < arr.length; index++) {
                const file = arr[index];
                if (file.size < 1) {
                    throw new Error("Invalid file.");
                }
                if (!file.type.startsWith('image/')) {
                    throw new Error("Ensure to upload an image file.");
                }

                if(file.type.startsWith('image/')){
                    document.getElementById('post_images_div').innerHTML = document.getElementById('post_images_div').innerHTML + 
                    `<div class="w-4/5 md:w-1/4 lg:w-1/5 h-52 cursor-pointer relative mx-auto m-1" onclick="showImageFullScreen(this, event)">
                        <img src="${URL.createObjectURL(file)}" alt="" class="w-full h-full object-cover" id='image'>
                        <button class="text-gray-900 cursor-pointer text-2xl h-12 w-12 flex items-center justify-center p-4 hover:bg-gray-200 rounded-full hover:bg-opacity-50 absolute top-2 right-2" onclick="removeImage('${file.name}', this, event)">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>`;
                }

                postImages.push(file);
            }
        } catch (error) {
            toastr.error(error)
        }
        document.getElementById('post_input').value = null;
        document.getElementById('post_input_2').value = null;
    }
    document.getElementById('post_input').onchange = () => {
        putPictures();
    }
    document.getElementById('post_input_2').onchange = () => {
        putPictures();
    }
</script>