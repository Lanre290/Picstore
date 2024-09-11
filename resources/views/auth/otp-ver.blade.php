@include('includes.preauth-header', ['url' => 'Verify your account'])

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
        <h3 class="text-blue-500 cursor-pointer hover:underline">Resend OTP</h3>
    </div>
</body>


<style>
    .otp_input:focus{
        outline: none;
        border: 2px solid #60a5fa;
    }
</style>

<script>
    document.querySelectorAll('.otp_input').forEach((element, index) => {
        element.oninput = () => {
            if(element.value.length == 1){
                index !== 3  && element.nextElementSibling.focus();
            }
            else if(element.value.length < 1){
                index !== 0 && element.previousElementSibling.focus();
            }
        }
    });

</script>