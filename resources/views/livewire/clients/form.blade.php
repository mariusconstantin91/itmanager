<div x-data="{ showSuccessAlert: 'true' }">
    <form
        wire:submit.prevent="save"
        id="actions-form"
    >
        @csrf
        <div class="align-start mb-4 flex">
            <div class="text-3xl font-semibold text-black-500">
                {{ $title }}
            </div>
            <div class="ml-auto w-auto">
                <a
                    class="mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
                    href="{{ route('clients.index') }}"
                >Cancel</a>
                <button
                    class="rounded-lg bg-gray-900 py-2 px-5 pb-2.5 text-sm font-medium text-white hover:bg-green-700"
                    wire:loading.attr="disabled"
                    @click="showSuccessAlert = true;"
                    type="submit"
                >Save</button>
            </div>
        </div>
        <div class="main-content mb-16">
            <div class="flex flex-wrap">
                <x-alerts.success />
                <div class="w-full">
                    <x-panel label="Info">
                        <div class="grid grid-cols-1 gap-4" >
                            <x-input-group
                                type="text"
                                placeholder=""
                                id="name"
                                name="client.name"
                                required="required"
                                wire:model.lazy="client.name"
                                labelText="Name"
                            > </x-input-group>
                            <x-input-group
                                type="text"
                                placeholder=""
                                id="name"
                                name="client.source"
                                required="required"
                                wire:model.lazy="client.source"
                                labelText="Source"
                            > </x-input-group>
                        </div>
                    </x-panel>
                    <x-panel label="Contacts" contentClasses="bg-white p-4 " wrapperExtraClasses="mt-8">
                        <ul class="mb-6">
                            @forelse($this->contactItems as $key => $contactItem)
                                <li class="mb-4 items-center gap-4 grid grid-cols-4 border-b border-gray-300 pb-4">
                                    <x-input-group
                                        type="switch"
                                        id="contactItems.{{ $key }}.main_contact"
                                        name="contactItems.{{ $key }}.main_contact"
                                        wire:model.lazy="contactItems.{{ $key }}.main_contact"
                                        labelText="Main contact"
                                        labelClass="text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer"
                                        wrapperClass="flex"
                                    />
                                    <x-input-group
                                        type="text"
                                        id="contactItems.{{ $key }}.name"
                                        name="contactItems.{{ $key }}.name"
                                        wire:model.lazy="contactItems.{{ $key }}.name"
                                        labelText="Name"
                                        
                                        required
                                    />
                                    <x-input-group
                                        type="text"
                                        id="contactItems.{{ $key }}.position"
                                        name="contactItems.{{ $key }}.position"
                                        wire:model.lazy="contactItems.{{ $key }}.position"
                                        labelText="Position"
                                        
                                    />
                                    <x-input-group
                                        type="phone"
                                        id="contactItems.{{ $key }}.phone"
                                        name="contactItems.{{ $key }}.phone"
                                        wire:model.lazy="contactItems.{{ $key }}.phone"
                                        labelText="Phone"
                                        
                                        required
                                    />
                                    <x-input-group
                                        type="email"
                                        id="contactItems.{{ $key }}.email"
                                        name="contactItems.{{ $key }}.email"
                                        wire:model.lazy="contactItems.{{ $key }}.email"
                                        labelText="Email"
                                        
                                        required
                                    />
                                    <x-input-group
                                        type="select"
                                        id="contactItems.{{ $key }}.country_id"
                                        name="contactItems.{{ $key }}.country_id"
                                        wire:model.lazy="contactItems.{{ $key }}.country_id"
                                        :options="$this->countryOptions"
                                        labelText="Country"
                                        selected="Select"
                                        
                                    />
                                    <x-input-group
                                        type="text"
                                        id="contactItems.{{ $key }}.city"
                                        name="contactItems.{{ $key }}.city"
                                        wire:model.lazy="contactItems.{{ $key }}.city"
                                        labelText="City"
                                        
                                    />
                                    <x-input-group
                                        type="text"
                                        id="contactItems.{{ $key }}.postalcode"
                                        name="contactItems.{{ $key }}.postalcode"
                                        wire:model.lazy="contactItems.{{ $key }}.postalcode"
                                        labelText="Postal code"
                                        
                                    />
                                    <x-input-group
                                        type="text"
                                        id="contactItems.{{ $key }}.address_line_1"
                                        name="contactItems.{{ $key }}.address_line_1"
                                        wire:model.lazy="contactItems.{{ $key }}.address_line_1"
                                        labelText="Address line 1"
                                        
                                    />
                                    <x-input-group
                                        type="text"
                                        id="contactItems.{{ $key }}.address_line_2"
                                        name="contactItems.{{ $key }}.address_line_2"
                                        wire:model.lazy="contactItems.{{ $key }}.address_line_2"
                                        labelText="Address line 2"
                                        
                                    />
                                    
                                    <x-delete-button
                                        :key="$key"
                                        class="mt-2"
                                    />
                                </li>
                            @empty
                                <li>
                                    <span class="text-sm text-gray-500">No items</span>
                                </li>
                            @endforelse
                        </ul>
                        <button
                            type="button"
                            class="flex items-center rounded-lg bg-gray-200 px-3 py-2 text-xs hover:bg-gray-300"
                            wire:click.prevent="addNewLine"
                        >
                            Add Contact <i class="fa-solid fa-plus ml-2"></i>
                        </button>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
