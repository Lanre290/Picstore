<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{asset('img/favicon.png') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="resetPassword.js"></script>
    <title>Reset your password</title>
</head>


<body class="w-screen h-screen flex flex-col justify-center items-center">
    <form action="{{ route('api/reset-password') }}" method="POST" id="reset-pwd-form" class="w-full md:w-4/6 lg:w-5/12 h-screen flex flex-col items-center justify-center" onsubmit="validatePwdReset()">
        @csrf
        <div class="text-xl md:text-4xl text-gray-900 mx-auto mb-7 flex flex-row font-light">Reset your password</div>
        <input type="hidden" name="id" value="{{$user->id}}">
        <input type="password" id="pwd" placeholder="Password..." class="p-4 text-gray-800 bg-gray-900 bg-opacity-5 w-5/6 mx-auto mb-4"/>
        <input type="password" name="pwd" id="repeat-pwd" placeholder="Repeat password..." class="p-4 text-gray-800 bg-gray-900 bg-opacity-5 w-5/6 mx-auto mb-4"/>

        <button class="py-2 px-6 bg-blue-500 text-gray-50 shadow-md rounded-md cursor-pointer  hover:bg-blue-600 disabled:bg-blue-200 w-5/6 sm:w-4/6 md:w-4/6 lg:w-3/6 mx-auto flex flex-row items-center justify-center" id="loginbtn">Reset password</button>
        
    </form>


    <script>
        async function validatePwdReset(event){
            event.preventDefault();
            try {
                let formData = new FormData(document.getElementById('reset-pwd-form'));
                let pwd = document.getElementById('pwd').value;
                let repeatPwd = document.getElementById('repeat-pwd').value;

                if(pwd != repeatPwd){
                    throw new Error('Passwords do not match.');
                }

                if(pwd.length < 1 || repeatPwd.length < 1){
                    throw new Error('Fill in all fields.');
                }

                const response = await fetch("/api/reset-password", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });


                if (response.ok) {
                    window.location.href = '/login';
                }
                else{
                    let res = await response.json();
                    throw new Error(res.error);
                }
            } catch (error) {
                toastr.error(error);
            }
        }
    </script>

</body>