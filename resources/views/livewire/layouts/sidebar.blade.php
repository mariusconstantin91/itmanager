<div
    class="index-0 flex min-h-fit shrink-0 grow-0 bg-white pb-5"
    x-cloak
    x-bind:class="activeSidebar ? 'w-2/12' : 'w-[5%]'"
>
@php
    $userAuth = auth()->user();
@endphp
    <div class="w-full">
        <div class="flex justify-center">
            <ul class="flex w-full flex-col gap-x-3.5">
                <li
                    @if (strpos(
                        request()->route()->getName(),
                        'users',
                    ) !== false ||
                    strpos(
                        request()->route()->getName(),
                        'documents',
                    ) !== false ||
                    strpos(
                        request()->route()->getName(),
                        'holidays',
                    ) !== false) x-data="{open: true}" @else x-data="{open: false}" @endif>
                    <a
                        href="#"
                        @click.prevent="open = ! open"
                        class="group flex cursor-pointer items-center px-6 py-2 text-gray-600 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                    >
                        <div
                            class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <span
                            class="whitespace-nowrap text-sm font-medium"
                            x-cloak
                            x-show="activeSidebar"
                        >
                            Users
                        </span>
                        <div class="ml-auto flex">
                            <i
                                class="fa-solid fa-chevron-down text-sm"
                                x-bind:class="open ? 'rotate-180' : ''"
                            ></i>
                        </div>
                    </a>
                    <ul
                        class="flex w-full flex-col duration-700 ease-in"
                        x-cloak
                        x-show="open"
                    >
                        <li>
                            <a
                                href="{{ route('users.index') }}"
                                class="group @if (strpos(
                                    request()->route()->getName(),
                                    'users',
                                ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif flex cursor-pointer items-center px-6 py-2 pl-12 text-gray-600 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                            >
                                <div
                                    class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                    <i class="fa-solid fa-list"></i>
                                </div>
                                <span
                                    class="whitespace-nowrap text-sm font-medium"
                                    x-cloak
                                    x-show="activeSidebar"
                                >
                                    Overview
                                </span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('holidays.index') }}"
                                class="group @if (strpos(
                                    request()->route()->getName(),
                                    'holidays',
                                ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif flex cursor-pointer items-center px-6 py-2 pl-12 text-gray-600 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                            >
                                <div
                                    class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                    <i class="fa-solid fa-mountain-city"></i>
                                </div>
                                <span
                                    class="whitespace-nowrap text-sm font-medium"
                                    x-cloak
                                    x-show="activeSidebar"
                                >
                                    Holidays
                                </span>
                            </a>
                        </li>
                        <li>
                            <a
                                href="{{ route('documents.index') }}"
                                class="group @if (strpos(
                                    request()->route()->getName(),
                                    'documents',
                                ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif flex cursor-pointer items-center px-6 py-2 pl-12 text-gray-600 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                            >
                                <div
                                    class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                                <span
                                    class="whitespace-nowrap text-sm font-medium"
                                    x-cloak
                                    x-show="activeSidebar"
                                >
                                    Documents
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if ($userAuth->hasAnyRole(['admin', 'pr_manager']))
                    <li>
                        <a
                            href="{{ route('clients.index') }}"
                            class="@if (strpos(
                                request()->route()->getName(),
                                'clients',
                            ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif group flex cursor-pointer items-center px-6 py-2  transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                        >
                            <div
                                class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <span
                                class="whitespace-nowrap text-sm font-medium"
                                x-cloak
                                x-show="activeSidebar"
                            >
                                Clients
                            </span>
                        </a>
                    </li>
                @endif
                @if ($userAuth->hasAnyRole(['admin', 'pr_manager']))
                    <li>
                        <a
                            href="{{ route('contacts.index') }}"
                            class="@if (strpos(
                                request()->route()->getName(),
                                'contacts',
                            ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif group flex cursor-pointer items-center px-6 py-2  transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                        >
                            <div
                                class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                <i class="fa-solid fa-address-card"></i>
                            </div>
                            <span
                                class="whitespace-nowrap text-sm font-medium"
                                x-cloak
                                x-show="activeSidebar"
                            >
                                Contacts
                            </span>
                        </a>
                    </li>
                @endif
                @if ($userAuth->hasAnyRole(['admin', 'pr_manager', 'user']))
                    <li>
                        <a
                            href="{{ route('projects.index') }}"
                            class="@if (strpos(
                                request()->route()->getName(),
                                'projects',
                            ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif group flex cursor-pointer items-center px-6 py-2 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                        >
                            <div
                                class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                <i class="fa-solid fa-diagram-project"></i>
                            </div>
                            <span
                                class="whitespace-nowrap text-sm font-medium"
                                x-cloak
                                x-show="activeSidebar"
                            >
                                Projects
                            </span>
                        </a>
                    </li>
                @endif
                @if ($userAuth->hasAnyRole(['admin', 'pr_manager', 'user']))
                    <li>
                        <a
                            href="{{ route('task_groups.index') }}"
                            class="@if (strpos(
                                request()->route()->getName(),
                                'task_groups',
                                ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif group flex cursor-pointer items-center px-6 py-2  transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90">
                            <div
                                class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                <i class="fa-solid fa-folder-tree"></i>
                            </div>
                            <span
                                class="whitespace-nowrap text-sm font-medium"
                                x-cloak
                                x-show="activeSidebar"
                            >
                                Task Groups
                            </span>
                        </a>
                    </li>
                @endif
                @if ($userAuth->hasAnyRole(['admin', 'pr_manager', 'user']))
                    <li>
                        <a
                        href="{{ route('tasks.index') }}"
                        class="@if (strpos(
                            request()->route()->getName(),
                            'tasks',
                            ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif group flex cursor-pointer items-center px-6 py-2  transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90">
                            <div
                                class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <span
                                class="whitespace-nowrap text-sm font-medium"
                                x-cloak
                                x-show="activeSidebar"
                            >
                                Tasks
                            </span>
                        </a>
                    </li>
                @endif
                @if ($userAuth->hasAnyRole(['admin', 'pr_manager', 'user']))
                    <li>
                        <a
                            href="{{ route('time_entries.index') }}"
                            class="@if (strpos(
                            request()->route()->getName(),
                            'time_entries',
                            ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif group flex cursor-pointer items-center px-6 py-2  transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                        >
                            <div
                                class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <span
                                class="whitespace-nowrap text-sm font-medium"
                                x-cloak
                                x-show="activeSidebar"
                            >
                                Time entries
                            </span>
                        </a>
                    </li>
                @endif
                @if ($userAuth->hasAnyRole(['admin', 'pr_manager', 'user']))
                    <li>
                        <a
                            href="{{ route('comments.index') }}"
                            class="@if (strpos(
                            request()->route()->getName(),
                            'comments',
                            ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif group flex cursor-pointer items-center px-6 py-2  transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                        >
                            <div
                                class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                <i class="fa-solid fa-comment"></i>
                            </div>
                            <span
                                class="whitespace-nowrap text-sm font-medium"
                                x-cloak
                                x-show="activeSidebar"
                            >
                                Comments
                            </span>
                        </a>
                    </li>
                @endif
                <li
                    @if (strpos(
                        request()->route()->getName(),
                        'settings',
                    ) !== false) x-data="{open: true}" @else x-data="{open: false}" @endif>
                    <a
                        href="#"
                        @click.prevent="open = ! open"
                        class="group flex cursor-pointer items-center px-6 py-2 text-gray-600 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                    >
                        <div
                            class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <span
                            class="whitespace-nowrap text-sm font-medium"
                            x-cloak
                            x-show="activeSidebar"
                        >
                            Settings
                        </span>
                        <div class="ml-auto flex">
                            <i
                                class="fa-solid fa-chevron-down text-sm"
                                x-bind:class="open ? 'rotate-180' : ''"
                            ></i>
                        </div>
                    </a>
                    <ul
                        class="flex w-full flex-col duration-700 ease-in"
                        x-cloak
                        x-show="open"
                    >
                        <li>
                            <a
                                href="{{ route('settings.tags.index') }}"
                                class="group @if (strpos(
                                    request()->route()->getName(),
                                    'tags',
                                ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif flex cursor-pointer items-center px-6 py-2 pl-12 text-gray-600 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                            >
                                <div
                                    class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                    <i class="fa-solid fa-tags"></i>
                                </div>
                                <span
                                    class="whitespace-nowrap text-sm font-medium"
                                    x-cloak
                                    x-show="activeSidebar"
                                >
                                    Tags
                                </span>
                            </a>
                        </li>
                        <li>
                            <a
                            href="{{ route('settings.skills.index') }}"
                            class="group @if (strpos(
                                request()->route()->getName(),
                                'skills',
                            ) !== false) text-green-700 bg-green-50  @else text-gray-600 @endif flex cursor-pointer items-center px-6 py-2 pl-12 text-gray-600 transition-opacity duration-300 hover:bg-green-50 hover:fill-green-700 hover:text-green-700 hover:opacity-90"
                            >
                                <div
                                    class="min-w-7 min-h-7 flex h-7 w-7 items-center justify-start rounded-xl fill-inherit">
                                    <i class="fa-solid fa-cubes"></i>
                                </div>
                                <span
                                    class="whitespace-nowrap text-sm font-medium"
                                    x-cloak
                                    x-show="activeSidebar"
                                >
                                    Skills
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
