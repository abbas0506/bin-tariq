<aside aria-label="Sidebar" id='sidebar'>
    <div class="flex justify-center items-center h-24 mt-6">
        <img src="{{ asset('images/logo/dark_green.png') }}" alt="logo" class="w-20">
    </div>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Admission</div>
    <hr class="border-teal-600 border-2 rounded-full mt-3 w-1/2 mx-auto">

    <div class="mt-12">
        <ul class="grid gap-y-4 font-medium">
            <li>
                <a href="{{ url('/') }}" class="flex items-center">
                    <i class="bi-house"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admission.applications.index') }}" class="flex items-center">
                    <i class="bi-file-earmark-text"></i>
                    <span class="ml-3">Applications</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admission.fee.index') }}" class="flex items-center">
                    <i class="bi-currency-rupee"></i>
                    <span class="ml-3">Fee Log</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admission.rejections.index') }}" class="flex items-center">
                    <i class="bi-file-earmark-excel"></i>
                    <span class="ml-3">Rejection List</span>
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
