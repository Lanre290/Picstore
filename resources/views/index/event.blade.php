@include('includes.header-script', ['url' => 'The wedding party'])

<body>
    @include('includes.topnav')

    <div class="fixed top-10 right-0 left-0 flex flex-col pt-10">
        <div class="flex flex-col-reverse md:flex-row justify-between w-full">
            <div class="bg-blue-400 w-11/12 mx-auto mb-2 md:w-auto cursor-pointer px-4 py-3 text-gray-50 ml-3 hover:bg-blue-500 relative">
                Create a new event
                <input type="file" name="" id="" class="absolute top-0 left-0 right-0 bottom-0 opacity-0 cursor-pointer" multiple>
            </div>
        </div>
    </div>
    <div class="w-full border-t border-gray-300 mt-3 ">
        
    </div>
</body>