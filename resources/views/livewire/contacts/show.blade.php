<div>
    <div class="align-start mb-4 flex">
        <h1 class="text-3xl font-semibold text-black-500">
            Contact #{{ $this->contact->id }} - {{ $this->contact->name  }}
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
                                    <td class="px-1"><span class="font-medium">Main Contact:</span></td>
                                    <td class="px-1"> 
                                        @if ($this->contact->main_contact)
                                            yes
                                        @else
                                            no
                                        @endif
                                    </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Name:</span></td>
                                    <td class="px-1"> {{ $this->contact->name }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Email:</span></td>
                                    <td class="px-1"> {{ $this->contact->email }} </td>
                                </tr>
                                @if ($this->contact->client)
                                    <tr class="my-2.5">
                                        <td class="px-1"><span class="font-medium">Client:</span></td>
                                        <td class="px-1"> {{ $this->contact->client->name }} </td>
                                    </tr>
                                @endif
                                @if ($this->contact->phone)
                                    <tr class="my-2.5">
                                        <td class="px-1"><span class="font-medium">Phone:</span> </td>
                                        <td class="px-1">{{ $this->contact->phone }} </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="mb-2">
                            <h2 class="mb-2 text-lg font-medium">Address</h2>
                            <table class="text-sm">
                                @if ($this->contact->country)
                                    <tr class="my-2.5">
                                        <td class="px-1"><span class="font-medium">Country:</span></td>
                                        <td class="px-1"> {{ $this->contact->country->name }}</td>
                                    </tr>
                                @endif
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">City:</span></td><td class="px-1"> {{ $this->contact->city }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Address line 1:</span></td>
                                    <td class="px-1"> {{ $this->contact->address_line_1 }}</td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Address line 1:</span></td>
                                    <td class="px-1"> {{ $this->contact->address_line_2 }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Postal Code:</span></td>
                                    <td class="px-1"> {{ $this->contact->postalcode }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </x-panel>                         
            </div>
        </div>
    </div>
</div>
