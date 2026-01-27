<aside aria-label="Sidebar" id='sidebar'>
    <div class="flex justify-center items-center h-24 mt-6">
        <img src="{{ asset('images/logo/ghs-32.png') }}" alt="logo" class="w-20">
    </div>
    <div class="mt-8 font-bold text-center text-orange-300 uppercase tracking-wider">Principal</div>
    <hr class="border-teal-600 border-2 rounded-full mt-3 w-1/2 mx-auto">

    <div class="my-8">
        <ul class="grid gap-y-4 text-xs md:text-sm">
            <li>
                <a href="{{ url('/') }}" class="flex items-center">
                    <i class="bi-house"></i>
                    <span class="ml-3">Home</span>
                </a>
            </li>
            <li>
                <a href="{{ route('users.index') }}" class="flex items-center">
                    <i class="bi bi-person-circle"></i>
                    <span class="ml-3">Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('subjects.index') }}" class="flex items-center">
                    <i class="bx bx-book"></i>
                    <span class="ml-3">Subjects</span>
                </a>
            </li>
            <li>
                <a href="{{ route('sections.index') }}" class="flex items-center">
                    <i class="bi bi-layers"></i>
                    <span class="ml-3">Classes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('class-schedule') }}" class="flex items-center">
                    <i class="bi-clock"></i>
                    <span class="ml-3">Schedule</span>
                </a>
            </li>
            <li>
                <a href="{{ route('attendance.summary') }}" class="flex items-center">
                    <i class="bi bi-person-check"></i>
                    <span class="ml-3">Attendance</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bulk-invoices.index') }}" class="flex items-center">
                    <i class="bi-receipt"></i>
                    <span class="ml-3">Fee</span>
                </a>
            </li>
            <li>
                <a href="{{ route('salaries.index') }}" class="flex items-center">
                    <i class="bi-receipt"></i>
                    <span class="ml-3">Salaries</span>
                </a>
            </li>
            <li>
                <a href="{{ route('expenses.index') }}" class="flex items-center">
                    <i class="bi-coin"></i>
                    <span class="ml-3">Expenses</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ledger.index') }}" class="flex items-center">
                    <i class="bi-receipt"></i>
                    <span class="ml-3">Accounts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tests.index') }}" class="flex items-center">
                    <i class="bi-clipboard-check"></i>
                    <span class="ml-3">Assessment</span>
                </a>
            </li>

            <li>
                <a href="{{ route('tasks.index') }}" class="flex items-center">
                    <i class="bi bi-calendar-event"></i>
                    <span class="ml-3">Tasks Control </span>
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
