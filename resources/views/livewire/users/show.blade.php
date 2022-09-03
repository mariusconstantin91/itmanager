<div>
    <div class="align-start mb-4 flex">
        <h1 class="text-3xl font-semibold text-black-500">
            User #{{ $this->user->id }} - {{ $this->user->name  }}
        </h1>
    </div>
    <div class="main-content mb-16">
        <div class="flex flex-wrap">
            <div class="w-full">
                <x-panel label="Details" wrapperExtraClasses="mt-2">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h2 class="mb-2 text-lg font-medium">General info</h2>
                            <table class="text-sm">
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Name:</span></td>
                                    <td class="px-1"> {{ $this->user->name }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Email:</span></td>
                                    <td class="px-1"> {{ $this->user->email }} </td>
                                </tr>
                                @if ($this->user->role)
                                    <tr class="my-2.5">
                                        <td class="px-1"><span class="font-medium">Role:</span></td>
                                        <td class="px-1"> {{ $this->user->role->name }} </td>
                                    </tr>
                                @endif
                                @if ($this->user->phone)
                                    <tr class="my-2.5">
                                        <td class="px-1"><span class="font-medium">Phone:</span> </td>
                                        <td class="px-1">{{ $this->user->phone }} </td>
                                    </tr>
                                @endif
                                @if ($this->user->salary)
                                    <tr class="my-2.5">
                                        <td class="px-1"><span class="font-medium">Salary:</span></td>
                                        <td class="px-1"> {{ $this->user->salary }}$ </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="mb-2">
                            <h2 class="mb-2 text-lg font-medium">Address</h2>
                            <table class="text-sm">
                                @if ($this->user->country)
                                    <tr class="my-2.5">
                                        <td class="px-1"><span class="font-medium">Country:</span></td>
                                        <td class="px-1"> {{ $this->user->country->name }}</td>
                                    </tr>
                                @endif
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">City:</span></td><td class="px-1"> {{ $this->user->city }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Address line 1:</span></td>
                                    <td class="px-1"> {{ $this->user->address_line_1 }}</td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Address line 1:</span></td>
                                    <td class="px-1"> {{ $this->user->address_line_2 }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Postal Code:</span></td>
                                    <td class="px-1"> {{ $this->user->postalcode }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="mb-2">
                            <h2 class="mb-2 text-lg font-medium">Skills</h2>
                            <x-skills :entities="$this->user->skills"/>
                        </div>
                    </div>
                </x-panel>
                <x-panel label="Holidays" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableHolidays">
                    </x-datatable::layout>
                </x-panel>

                <x-panel label="Documents" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableDocuments">
                    </x-datatable::layout>
                </x-panel>

                <x-panel label="Projects" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableProjects">
                    </x-datatable::layout>
                </x-panel>

                <x-panel label="Tasks" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableTasks">
                    </x-datatable::layout>
                </x-panel>
                         
            </div>
        </div>
    </div>
</div>
