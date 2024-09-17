function closeUploadImage(){
    let btn = document.getElementById('upload_pictures_btn');
    btn.innerText = 'Save images';
    btn.disabled = false;
    btn.style.backgroundColor = ' rgb(96 165 250)';
    btn.style.cursor = 'pointer';
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

async function createEvent(element){
    let button = element.querySelector('button');
    button.innerHTML = `
    <svg fill="#ffffff" class="animate-spin text-primary mr-1 w-7 h-7" aria-label="Loading..." aria-hidden="true" data-testid="icon" width="16" height="17" viewBox="0 0 16 17" xmlns="http://www.w3.org/2000/svg">
        <path d="M4.99787 2.74907C5.92398 2.26781 6.95232 2.01691 7.99583 2.01758V3.01758C7.10643 3.01768 6.23035 3.23389 5.44287 3.64765C4.6542 4.06203 3.97808 4.66213 3.47279 5.39621C2.9675 6.13029 2.64821 6.97632 2.54245 7.86138C2.51651 8.07844 2.5036 8.29625 2.50359 8.51367H1.49585C1.49602 8.23118 1.51459 7.94821 1.55177 7.66654C1.68858 6.62997 2.07326 5.64172 2.67319 4.78565C3.27311 3.92958 4.07056 3.23096 4.99787 2.74907Z"></path><path opacity="0.15" fill-rule="evenodd" clip-rule="evenodd" d="M8 14.0137C11.0376 14.0137 13.5 11.5512 13.5 8.51367C13.5 5.47611 11.0376 3.01367 8 3.01367C4.96243 3.01367 2.5 5.47611 2.5 8.51367C2.5 11.5512 4.96243 14.0137 8 14.0137ZM8 15.0137C11.5899 15.0137 14.5 12.1035 14.5 8.51367C14.5 4.92382 11.5899 2.01367 8 2.01367C4.41015 2.01367 1.5 4.92382 1.5 8.51367C1.5 12.1035 4.41015 15.0137 8 15.0137Z">
        </path>
    </svg> Loading...`;

    const response = await fetch('/api/create-event', {
        method: 'POST',
        body: formData
    });
    

    if(response.ok){
        // do something.
    }
    else{
        let res = await response.json();
        toastr.error(res.error);
    }
}

