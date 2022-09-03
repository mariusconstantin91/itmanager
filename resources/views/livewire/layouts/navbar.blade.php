<nav class="h-14 px-4 py-8">
    @auth
        <div class="float-right pr-4">
            <a
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="rounded-lg bg-gray-900 py-2 px-3.5 text-sm font-medium text-white shadow-xl"
            >
                Log out
            </a>

            <form
                id="logout-form"
                action="{{ route('logout') }}"
                method="POST"
                style="display: none;"
            >
                @csrf
            </form>
        </div>
    @endauth
    @guest
        <div class="float-right pr-4">
            <a
                class="mr-4 rounded-lg bg-gray-900 py-2 px-3.5 text-sm font-medium text-white shadow-xl"
                href="/login"
            >Login</a>
        </div>
    @endguest
</nav>
