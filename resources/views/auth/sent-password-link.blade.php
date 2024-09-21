@include('includes.header-script', ['url' => 'Password verification link sent to '.session('password_reset')->email])

<div class="w-full md:w-4/6 lg:w-5/12 h-screen flex flex-col items-center justify-center mx-auto">
    <h3 class="text-gray-900 text-center">We sent an emaail to {{ session('password_reset')->email }}, Please check your mail to proceed.</h3>
    <a href="https://mail.google.com/mail/" target="_blank" class="px-3 py-2 border border-gray-500 mx-auto rounded-md mt-4 mb-7 flex flex-row items-center justify-center hover:bg-gray-100">
        <img src="{{asset('img/google.png')}}" alt="google-logo" class="w-5 h-5 md:w-8 md:h-8 mr-2">
        Open G-mail
    </a>
</div>