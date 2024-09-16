@include('includes.header-script', ['url' => 'The wedding party'])
@include('includes.session-auth');

<body>
    @include('includes.topnav')

    <div class="fixed top-10 right-0 left-0 flex flex-col pt-10">
        <div class="flex flex-col md:flex-row w-full">
            <div class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500 relative">
                <h3 class="text-center">Upload picture</h3>
                <input type="file" name="" id="post_input" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" multiple>
            </div>
            <button class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer px-4 py-3 text-center text-gray-50 ml-3 hover:bg-blue-500" data-id="" onclick="resetEventLink(this)">
                Reset Link
            </button>
            <button class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer text-center px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500" data-link='' onclick="copyEventLink()">
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
                    <button class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer text-center px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500" id="upload_pictures_btn">
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


    @include('includes.loading')

    <div class="fixed top-0 bottom-0 right-0 left-0 bg-black bg-opacity-50 flex items-center justify-center z-40" style="display: none;" id="event_link_div">
        <div class="w-full h-full md:h-auto md:w-1/2 z-50 bg-gray-50 md:p-10">
            <div class="flex flex-row justify-between w-full h-12 m-3 mb-5 items-center">
                <h3 class=""></h3>
                <h3 class="text-2xl text-gray-900 text-center">Copy event link</h3>
                <button class="text-gray-900 mr-5 md:m-0 cursor-pointer text-2xl h-12 w-12 flex items-center justify-center p-4 hover:bg-gray-200 rounded-full hover:bg-opacity-50" id="close_copy_event_link_id">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            <div class="w-11/12 md:w-1/2 rounded-md h-10 flex flex-row border border-gray-400 mx-auto">
                <div class="text-sm text-gray-900 rounded-tl-md rounded-bl-md flex flex-grow p-2 font-light" id="event-link-div">
                    
                </div>
                <button class="p-1 text-sm text-gray-900 rounded-tr-md rounded-br-md cursor-pointer w-10 border-l" title="copy event link" onclick="copyEventLink()">
                    <i class="fa fa-copy"></i>
                </button>
            </div>
        </div>
    </div>

    <input type="hidden" name="csrf-token-save-images" value="{{ csrf_token() }}">

</body>




<script>

    let postImages = [];

    document.getElementById('close_copy_event_link_id').onclick = () => {
        document.getElementById('event_link_div').style.display = 'none';
    }

    function removeImage(name, element, event){
        event.stopPropagation();
        element.parentElement.style.display = 'none';
        let index = postImages.findIndex(fileObj => fileObj.name === name)
        postImages.splice(index, 1);

        console.log(postImages);
    }

    document.getElementById('event-link-div').innerText = window.location.href;

    function putPictures(){
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

    function saveImages(){
        event.preventDefault();
        let btn = document.getElementById('upload_pictures_btn');
        btn.innerHTML = `
        <svg fill="currentColor" class="animate-spin text-primary mr-1 w-7 h-7" aria-label="Loading..." aria-hidden="true" data-testid="icon" width="16" height="17" viewBox="0 0 16 17" xmlns="http://www.w3.org/2000/svg"><path d="M4.99787 2.74907C5.92398 2.26781 6.95232 2.01691 7.99583 2.01758V3.01758C7.10643 3.01768 6.23035 3.23389 5.44287 3.64765C4.6542 4.06203 3.97808 4.66213 3.47279 5.39621C2.9675 6.13029 2.64821 6.97632 2.54245 7.86138C2.51651 8.07844 2.5036 8.29625 2.50359 8.51367H1.49585C1.49602 8.23118 1.51459 7.94821 1.55177 7.66654C1.68858 6.62997 2.07326 5.64172 2.67319 4.78565C3.27311 3.92958 4.07056 3.23096 4.99787 2.74907Z"></path><path opacity="0.15" fill-rule="evenodd" clip-rule="evenodd" d="M8 14.0137C11.0376 14.0137 13.5 11.5512 13.5 8.51367C13.5 5.47611 11.0376 3.01367 8 3.01367C4.96243 3.01367 2.5 5.47611 2.5 8.51367C2.5 11.5512 4.96243 14.0137 8 14.0137ZM8 15.0137C11.5899 15.0137 14.5 12.1035 14.5 8.51367C14.5 4.92382 11.5899 2.01367 8 2.01367C4.41015 2.01367 1.5 4.92382 1.5 8.51367C1.5 12.1035 4.41015 15.0137 8 15.0137Z"></path></svg>&nbsp;Posting`;
        btn.disabled = true;
        btn.style.backgroundColor = 'rgb(191, 219, 254)';
        btn.style.cursor = 'not-allowed';

        try{
            let formData = new FormData(document.getElementById('make-post-form'));
            postImages.forEach((file, index) => {
                formData.append(`files[]`, file);
            });
            const response = await fetch("api/upload-image", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="csrf-token-save-images"]').attr('content');
                }
            });

            if (response.ok) {
                console.log(response);
                postImages = [];
                window.location.reload();
                toastr.info('post successful.');
            } else {
                let res = await response.json();
                toastr.error('Error connecting to database.')
                console.error(res);
            }
        }
        catch(error){
            toastr.error(error);
            console.error(error)
        }
        finally{
            btn.disabled = false;
            btn.style.backgroundColor = 'rgb(59 130 246)';
            btn.style.cursor = 'pointer';
            btn.innerHTML = 'Post';
        }
    }

    document.getElementById('post_input').onchange = () => {
        putPictures();
    }
    document.getElementById('post_input_2').onchange = () => {
        putPictures();
    }
</script>