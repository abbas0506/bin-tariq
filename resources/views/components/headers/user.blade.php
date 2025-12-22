<header class="sticky-header">
    <div class="flex flex-wrap w-full h-16 items-center justify-between shadow-sm bg-white px-5">
        <div class="flex items-center space-x-2">
            <a href="{{ url('/') }}" class="flex justify-center">
                <img alt="logo" src="{{ asset('images/logo/dark_green.png') }}"
                    class="w-8 h-8 md:w-10 md:h-10 md:hidden">
            </a>
            <div class="hidden md:block text-base font-semibold">GHS 32/2L</div>
            @if (Auth::user()->roles->count() > 1)
                <select id="roleSwitcher"
                    class="ml-3 text-sm border-none focus:outline-none focus:ring-0 hover:cursor-pointer">

                    @foreach (Auth::user()->roles as $role)
                        <option value="{{ url('switch/as', $role->name) }}" class="ml-3" @selected($role->name == session('role'))>
                            {{ ucfirst($role->name) }} </option>
                    @endforeach

                </select>
            @endif
        </div>
        <div id=" current-user-area" class="flex space-x-3 items-center justify-center relative">
            <label for="toggle-current-user-dropdown" class="hidden md:flex items-center">
                <div class="">{{ Auth::user()->teacher->name }}</div>
            </label>
            <div id='menu' class="flex md:hidden">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </div>
</header>
<script>
    document.getElementById("roleSwitcher").addEventListener("change", function() {
        const url = this.value;
        if (url) {
            window.location.href = url; // Redirect to selected role’s page
        }
    });
</script>
