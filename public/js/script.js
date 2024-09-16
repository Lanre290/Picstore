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
    navigator.clipboard.writeText(window.location.href);
    toastr.info('Link copied to clipboard.');
}


async function resetEventLink(element){
    document.getElementById('loading').style.display = 'flex';
    let id = element.dataset.id;
    let formData = new FormData();
    formData.append('id', id)
    const response = await fetch('/api/reset-link', {
        method: 'POST',
        body: formData
    });

    if (response.ok) {
        let res = await response.json();
        let url = res.new_link;
        document.location.replace(`/event/${url}`);
        document.getElementById('loading').style.display = 'none';
    } else {
        toastr.error('Error');
        document.getElementById('loading').style.display = 'none';
    }
}

function createEvent(element){

}

