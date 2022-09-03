<div>
    <div class="align-start mb-4 flex">
        <h1 class="text-3xl font-semibold text-black-500">
            Client #{{ $this->client->id }} - {{ $this->client->name  }}
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
                                    <td class="px-1"> {{ $this->client->name }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Source:</span></td>
                                    <td class="px-1"> {{ $this->client->source }} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </x-panel>
                <x-panel label="Contacts" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableContacts">
                    </x-datatable::layout>
                </x-panel>

                <x-panel label="Projects" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableProjects">
                    </x-datatable::layout>
                </x-panel>
                         
            </div>
        </div>
    </div>
</div>
