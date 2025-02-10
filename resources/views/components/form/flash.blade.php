<div id="flash-container" class="relative w-full">
    @if(session('success'))
        <div id="flash-message"
             class="bg-white/80 text-green-500 p-4 rounded-lg shadow-lg fixed top-[180px] left-1/2 transform -translate-x-1/2 flex items-center justify-between w-fit max-w-full text-xl font-bold z-50">
            <span>{{ session('success') }}</span>
            <button id="close-flash" class="ml-4 text-gray-600 hover:text-red-500 text-2xl font-bold">&times;</button>
        </div>

        <script>
            document.getElementById('close-flash').addEventListener('click', function () {
                document.getElementById('flash-message').style.display = 'none';
            });
        </script>
    @endif
</div>
