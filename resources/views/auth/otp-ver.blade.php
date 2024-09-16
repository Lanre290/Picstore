@include('includes.preauth-header', ['url' => 'Verify your account', 'js' => 'signup.js']);

<body class="w-screen h-screen flex flex-col justify-center items-center">
    @include('includes.topnav')
    <h3 class="text-gray-90 mx-auto w-fit text-center md:w-2/5">We sent a One time passcode to <span class="text-blue-400 mx-1">lanre2967@gmail.com</span>, Enter the code you receive in the spaces below.</h3>
    <a href="https://mail.google.com/mail/" target="_blank" class="px-3 py-2 border border-gray-500 mx-auto rounded-md mt-4 mb-7 flex flex-row items-center justify-center hover:bg-gray-100">
        <img src="{{asset('img/google.png')}}" alt="google-logo" class="w-5 h-5 md:w-8 md:h-8 mr-2">
        Open G-mail
    </a>
    <div class="w-full flex flex-row items-center justify-center">
        <input type="password" class="px-4 py-5 text-3xl w-14 border-2 border-gray-500 rounded-lg m-1 otp_input" maxlength="1" />
        <input type="password" class="px-4 py-5 text-3xl w-14 border-2 border-gray-500 rounded-lg m-1 otp_input" maxlength="1" />
        <input type="password" class="px-4 py-5 text-3xl w-14 border-2 border-gray-500 rounded-lg m-1 otp_input" maxlength="1" />
        <input type="password" class="px-4 py-5 text-3xl w-14 border-2 border-gray-500 rounded-lg m-1 otp_input" maxlength="1" />
    </div>
    <div class="flex flex-row w-full justify-center mt-5">
        <h3 class="text-gray-90 text-center">Didn't get OTP ?,&nbsp;</h3>
        <h3 class="text-blue-500 cursor-pointer hover:underline" id="resend_otp">Resend OTP</h3>
    </div>

    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" id="email" value="{{session('user_details')['email']}}">
    <input type="hidden" id="pwd" value="{{session('user_details')['pwd']}}">

    @include('includes.loading')
</body>


<style>
    .otp_input:focus{
        outline: none;
        border: 2px solid #60a5fa;
    }
</style>

<script>

    document.getElementById('resend_otp').onclick = async () => {
        document.getElementById('loading').style.display = 'flex';
        const response = await fetch("api/auth/otp", {
            method: 'POST',
            body: formData,
        });


        if (response.ok) {
            
        } else {
            let res = await response.json();
            toastr.error(res.error);
        }
        
        document.getElementById('loading').style.display = 'none';
    }
    
    async function signIn(email, pwd){ 
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

            const formData = new FormData();
            formData.append('email', email);
            formData.append('pwd', pwd);

            try {
                const response = await fetch("api/auth/login", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });


                if (response.ok) {
                    window.location.href = '/dasboard';
                } else {
                    const errorData = await response.json();
                    throw new Error(errorData.error);
                }
            } catch (error) {
                toastr.error(error);
            }
        } catch (error) {
            toastr.error(error);
        }

        }


    document.querySelectorAll('.otp_input').forEach((element, index) => {
        element.oninput = async () => {
            if(element.value.length == 1){
                index !== 3  && element.nextElementSibling.focus();
                if(index === 3){

                    document.getElementById('loading').style.display = 'flex';
                    let token = ''
                    document.querySelectorAll('.otp_input').forEach((element) => {
                        token += element.value;
                    }); 
                    let formData = new FormData();
                    formData.append('token', token)
                    const response = await fetch("api/auth/check-otp", {
                        method: 'POST',
                        body: formData
                    });

                    if (response.ok) {
                        let res = await response.json();
                        let email = res.user_data.email;
                        let pwd = res.user_data.pwd;
                        console.log(res.user_data)

                        signIn(email, pwd);
                    } else {
                        let error = await response.json();
                        document.getElementById('loading').style.display = 'none';
                        toastr.error(error.error);
                        document.querySelectorAll('.otp_input').forEach((element, index) => {
                            element.value = '';
                            if(index == 0){
                                element.focus();
                            }
                        }); 
                    }
                }
            }
            else if(element.value.length < 1){
                index !== 0 && element.previousElementSibling.focus();
            }
        }
    });

</script>