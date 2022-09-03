<div class="relative flex w-full items-center bg-white py-4 px-6 shadow">
    <div class="flex-none">
        <a class="text-xl font-bold mr-4 text-gray-700" href="{{ url('/') }}">
            IT Manager
        </a>
    </div>
    <div
        class="flex-none pt-2"
        @click="activeSidebar = ! activeSidebar"
    >
        <svg
            height="17"
            width="27px"
            class="cursor-pointer"
        >
            <image xlink:href="{{ asset('img/burger.svg') }}" />
        </svg>
    </div>
    <div class="ml-auto">
        <div
            x-data="{ dropdownMenu: false }"
            class="relative"
            x-cloak
        >
            <!-- Dropdown toggle button -->
            <button
                @click="dropdownMenu = ! dropdownMenu"
                class="flex items-center rounded-md"
            >
                <div class="relative h-8 w-8">
                    <div
                        class="table h-full w-full cursor-pointer overflow-hidden rounded-full bg-gray-500 p-2 text-center align-middle text-xs font-bold text-white shadow-inner">
                        {{ preg_filter('/[^A-Z]/', '', auth()->user()->name) }}
                    </div>
                </div>
            </button>
            <!-- Dropdown list -->
            <div
                x-show="dropdownMenu"
                class="absolute right-0 mt-2 w-auto rounded-md border border-gray-100 bg-white bg-white shadow-xl"
            >
                <a
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="block whitespace-nowrap bg-white py-2 px-3.5 text-xs font-medium text-gray-500 hover:text-green-700"
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
                <a
                    href="#"
                    class="block whitespace-nowrap bg-white py-2 px-3.5 text-xs font-medium text-gray-500 hover:text-green-700"
                >
                    My Account
                </a>
            </div>
        </div>
    </div>
</div>
