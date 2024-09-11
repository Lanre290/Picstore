@include('includes.header-script', ['url' => 'Dashboard - Ashiru Sheriff'])
<body>
    @include('includes.topnav')
    <div class="fixed top-10 right-0 left-0 flex flex-col pt-10">
        <div class="flex flex-col-reverse md:flex-row justify-between w-full">
            <button class="bg-blue-400 w-11/12 mx-auto mb-2 md:w-auto cursor-pointer  px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500">Create a new event</button>
            <div class="text-blue-400 mr-5 cursor-pointer text-5xl m-2" title="Ashiru Sheriff">
                <i class="fa fa-user-circle"></i>
            </div>
        </div>
        <div class="w-full border-t border-gray-300 mt-3 ">
            <a href="/" class="w-full text-gray-900 hover:underline border-b h-14 px-4 flex flex-row justify-between items-center hover:bg-gray-100 ">
                Event 1 - 20th October, 2024
            </a>
        </div>
    </div>
</body>