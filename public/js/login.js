
const signInButton = document.getElementById('loginbtn');

async function validateSignIn(event){
    signInButton.innerHTML = `
    <svg fill="currentColor" class="animate-spin text-primary mr-1 w-7 h-7" aria-label="Loading..." aria-hidden="true" data-testid="icon" width="16" height="17" viewBox="0 0 16 17" xmlns="http://www.w3.org/2000/svg"><path d="M4.99787 2.74907C5.92398 2.26781 6.95232 2.01691 7.99583 2.01758V3.01758C7.10643 3.01768 6.23035 3.23389 5.44287 3.64765C4.6542 4.06203 3.97808 4.66213 3.47279 5.39621C2.9675 6.13029 2.64821 6.97632 2.54245 7.86138C2.51651 8.07844 2.5036 8.29625 2.50359 8.51367H1.49585C1.49602 8.23118 1.51459 7.94821 1.55177 7.66654C1.68858 6.62997 2.07326 5.64172 2.67319 4.78565C3.27311 3.92958 4.07056 3.23096 4.99787 2.74907Z"></path><path opacity="0.15" fill-rule="evenodd" clip-rule="evenodd" d="M8 14.0137C11.0376 14.0137 13.5 11.5512 13.5 8.51367C13.5 5.47611 11.0376 3.01367 8 3.01367C4.96243 3.01367 2.5 5.47611 2.5 8.51367C2.5 11.5512 4.96243 14.0137 8 14.0137ZM8 15.0137C11.5899 15.0137 14.5 12.1035 14.5 8.51367C14.5 4.92382 11.5899 2.01367 8 2.01367C4.41015 2.01367 1.5 4.92382 1.5 8.51367C1.5 12.1035 4.41015 15.0137 8 15.0137Z"></path></svg>&nbsp;Signin in`;
    signInButton.disabled = true;
    signInButton.style.backgroundColor = 'rgb(191, 219, 254)';
    signInButton.style.cursor = 'not-allowed';
    event.preventDefault();

    let email = document.getElementById('email').value;
    let pwd = document.getElementById('pwd').value;

    const validateEmail = (email) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    };

    try {
        if(email.length < 1 ||pwd.length < 1){
            throw new Error('Fill in all fields.');
        }
        if(!validateEmail(email)){
            throw new Error('Invalid Email.');
        }
        
        let form = document.getElementById('login-form');
        const formData = new FormData(form);

        try {
            const response = await fetch("/api/auth/login", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });

            if (response.ok) {
                window.location.replace('/dashboard');

            } else {
                const errorData = await response.json();
                signInButton.removeAttribute('disabled');
                signInButton.classList.remove('bg-blue-200');
                throw new Error(errorData.error);
            }
        } catch (error) {
            toastr.error(error);
        }
        finally{
            signInButton.disabled = false;
            signInButton.style.backgroundColor = 'rgb(59 130 246)';
            signInButton.style.cursor = 'pointer';
            signInButton.innerHTML = 'Log in';
        }
    } catch (error) {
        toastr.error(error);
        signInButton.removeAttribute('disabled');
        signInButton.classList.remove('bg-blue-200');
    }

}

signInButton.addEventListener('click', validateSignIn);


async function forgotPassword(){
    try {
        let email = document.getElementById('email').value;

        if(email.length  <1){
            throw new Error('Email field is required.');
        }

        document.getElementById('loading').style.display = 'flex';
        let formData = new FormData();
        formData.append('email', email);

        const response = await fetch("/api/forgot-password", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });


        if (response.ok) {
            window.location.href = '/password-link-sent';
        }
        else{

            let res = await response.json();
            toastr.error(res.error);
            document.getElementById('loading').style.display = 'none';
        }
    } catch (error) {
        toastr.error(error);
        document.getElementById('loading').style.display = 'none';
    }
}