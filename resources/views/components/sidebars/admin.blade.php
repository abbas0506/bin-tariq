<aside aria-label="Sidebar" id='sidebar'>
    <div class="flex justify-center items-center h-24 mt-6">
        <img src="{{ asset('images/logo/dark_green.png') }}" alt="logo" class="w-20">
    </div>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Admin</div>
    <hr class="border-teal-600 border-2 rounded-full mt-3 w-1/2 mx-auto">

    <div class="my-8">
        <ul class="grid gap-y-4 text-xs md:text-sm">
            <li>
                <a href="{{ url('admin') }}" class="flex items-center">
                    <i class="bi-house"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.sections.index') }}" class="flex items-center">
                    <i class="bi bi-diagram-3"></i>
                    <span class="ml-3">Classes</span>
                </a>
            </li>
            <li>
                <!-- <a href="{{ route('admin.section.lecture.schedule.index', [0, 0]) }}" class="flex items-center"> -->
                <a href="{{ route('admin.class-schedule') }}" class="flex items-center">
                    <i class="bi-clock"></i>
                    <span class="ml-3">Schedule</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.attendance.index') }}" class="flex items-center">
                    <i class="bi bi-person-check"></i>
                    <span class="ml-3">Attendance</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tests.index') }}" class="flex items-center">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="ml-3">Assessment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.vouchers.index') }}" class="flex items-center">
                    <i class="bi-receipt"></i>
                    <span class="ml-3">Vouchers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tasks.index') }}" class="flex items-center">
                    <i class="bi bi-calendar-event"></i>
                    <span class="ml-3">Misc. Tasks </span>
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
