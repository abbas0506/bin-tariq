<aside aria-label="Sidebar" id='sidebar'>
    <div class="flex justify-center items-center h-24 mt-6">
        <img src="{{ asset('images/logo/dark_green.png') }}" alt="logo" class="w-20">
    </div>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Library</div>
    <hr class="border-teal-600 border-2 rounded-full mt-3 w-1/2 mx-auto">

    <div class="mt-12">
        <ul class="grid gap-y-4">
            <li>
                <a href="{{ url('library') }}" class="flex items-center">
                    <i class="bi-house"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('library.book-issuance.scan') }}" class="flex items-center">
                    <i class="bi-upc"></i>
                    <span class="ml-3">Issue Book</span>
                </a>
            </li>
            <li>
                <a href="{{ route('library.book-return.scan') }}" class="flex items-center">
                    <i class="bi bi-hdd-rack"></i>
                    <span class="ml-3">Return Book</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center">
                    <i class="bi bi-person-slash"></i>
                    <span class="ml-3">Block Defaulters</span>
                </a>
            </li>
            <li>
                <a href="{{ url('library/print') }}" class="flex items-center">
                    <i class="bi bi-printer"></i>
                    <span class="ml-3">Print / Download</span>
                </a>
            </li>
            <li>
                <a href="{{ url('signout') }}" class="flex items-center">
                    <i class="bi bi-power"></i>
                    <span class="ml-3">Log Off</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
