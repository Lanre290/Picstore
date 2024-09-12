function closeUploadImage(){
   document.getElementById('upload_images').style.display = 'none';
   postImages = [];
   document.getElementById('post_images_div').innerHTML = '';
}


function showImageFullScreen(element, event){
    event.stopPropagation();
    let image = element.querySelector('#image');

    document.getElementById('image_fs_cont').style.display = 'flex';
    document.getElementById('image_fs').src = image.src;
}

function closeImageFs(){
   document.getElementById('image_fs_cont').style.display = 'none'; 
};

function stopPropagation(event){
    event.stopPropagation();
}

function closeCreateEvent(){
    document.getElementById('create_event_cont').style.display = 'none'; 
}

function openCreateEvent(){
    document.getElementById('create_event_cont').style.display = 'flex'; 
}

function copyEventLink(element){
    navigator.clipboard.writeText(element.dataset.link);
    toastr.info('Link copied to clipboard.');
}