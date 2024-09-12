@include('includes.header-script', ['url' => 'Dashboard - Ashiru Sheriff'])
<body>
    @include('includes.topnav')
    <div class="fixed top-10 right-0 left-0 flex flex-col pt-10">
        <div class="flex flex-col-reverse md:flex-row justify-between w-full">
            <button class="bg-blue-400 w-11/12 mx-auto mb-2 md:w-auto cursor-pointer  px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500" onclick="openCreateEvent()">Create a new event</button>
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

    <div class="fixed top-0 bottom-0 right-0 left-0 bg-black bg-opacity-50 flex items-center justify-center z-40" style="display: none;" id="create_event_cont">
        <div class="bg-gray-50 p-1 md:p-8 w-full h-full md:h-auto md:w-1/2">
            <div class="flex justify-end">
                <button class="text-gray-900 m-1 md:m-5 cursor-pointer text-2xl h-12 w-12 flex items-center justify-center p-4 hover:bg-gray-200 rounded-full hover:bg-opacity-50" onclick="closeCreateEvent()">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <form action="" class="w-full flex flex-col mt-24 justify-center items-center" method="post">
                <input type="text" name="title" id="title" placeholder="Title..." class="p-4 text-gray-800 bg-gray-900 bg-opacity-5 w-11/12 mx-auto mb-4"/>

                <button type="submit" class="bg-blue-400 w-11/12 mb-2 md:w-auto cursor-pointer text-center px-4 py-3 text-gray-50 md:ml-3 hover:bg-blue-500">
                   Create event
                </button>
            </form>

        </div>
    </div>
</body>