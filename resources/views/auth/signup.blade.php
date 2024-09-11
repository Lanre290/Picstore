@include('includes.preauth-header', ['url' => 'Create your picstore account.'])


<body class="w-screen h-screen flex flex-col justify-center items-center">
    <form action="{{ route('auth/sign-up') }}" method="POST" id="sign-up-form" class="w-full md:w-4/6 lg:w-5/12 h-screen flex flex-col items-center justify-center">
        @csrf
        <div class="text-xl md:text-4xl text-gray-900 mx-auto mb-7 flex flex-row font-light">Create your &nbsp;<span class="flex flex-col justify-center"><img src="{{asset('img/favicon.png')}}" alt="picstore-logo" class="w-5 h-5 md:w-8 md:h-8"></span> Picstore account</div>
        <input type="text" name="name" id="name" placeholder="Name E.g John Doe" class="p-4 text-gray-800 bg-gray-900 bg-opacity-5 w-5/6 mx-auto mb-4"/>
        <input type="text" name="email" id="email" placeholder="Email..." class="p-4 text-gray-800 bg-gray-900 bg-opacity-5 w-5/6 mx-auto mb-4"/>
        <input type="password" name="pwd" id="pwd" placeholder="Password..." class="p-4 text-gray-800 bg-gray-900 bg-opacity-5 w-5/6 mx-auto mb-4"/>
        <input type="password" id="pwd_rpt" placeholder="Password repeat..." class="p-4 text-gray-800 bg-gray-900 bg-opacity-5 w-5/6 mx-auto mb-4"/>

        <button class="py-2 px-6 bg-blue-500 text-gray-50 shadow-md rounded-md cursor-pointer  hover:bg-blue-600 disabled:bg-blue-400 w-5/6 sm:w-4/6 md:w-4/6 lg:w-3/6 mx-auto flex flex-row  items-center justify-center" id="signup-btn">Sign up</button>
        <div class="m-auto my-6">
            <span class="">Have an account?</span>
            <a class="text-blue-500" href="{{ route('login') }}">Login</a>
        </div>
    </form>
</body>