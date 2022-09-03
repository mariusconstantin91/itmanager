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
                    href="{{ route('contacts.index') }}"
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
                        <div class="grid grid-cols-3 gap-4">
                            <x-input-group
                                type="switch"
                                id="contact.main_contact"
                                name="contact.main_contact"
                                wire:model.lazy="contact.main_contact"
                                labelText="Main contact"
                                labelClass="text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer"
                                wrapperClass="flex"
                            />
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->contact->client,
                                )->name"
                                placeholder="Start typing"
                                id="contact.client_id"
                                name="contact.client_id"
                                wire:model.lazy="contact.client_id"
                                labelText="Client"
                                wrapperClass="col-start-1 col-end-2"
                                functionOptions="clientUpdated"
                            > </x-input-group>
                            <x-input-group
                                type="text"
                                id="contact.name"
                                name="contact.name"
                                wire:model.lazy="contact.name"
                                labelText="Name"
                                required
                                wrapperClass="col-start-1 col-end-2"
                            />
                            <x-input-group
                                type="text"
                                id="contact.position"
                                name="contact.position"
                                wire:model.lazy="contact.position"
                                labelText="Position"
                            />
                            <x-input-group
                                type="phone"
                                id="contact.phone"
                                name="contact.phone"
                                wire:model.lazy="contact.phone"
                                labelText="Phone"
                                required
                                wrapperClass="col-start-1 col-end-2"
                            />
                            <x-input-group
                                type="email"
                                id="contact.email"
                                name="contact.email"
                                wire:model.lazy="contact.email"
                                labelText="Email"
                                required
                            />
                        </div>
                    </x-panel>
                    <x-panel label="Address" wrapperExtraClasses="mt-8">
                        <div class="grid grid-cols-3 gap-4">
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->contact->country,
                                )->name"
                                placeholder="Start typing"
                                id="contact.country_id"
                                name="contact.country_id"
                                wire:model.lazy="contact.country_id"
                                labelText="Country"
                                functionOptions="countryUpdated"
                            > </x-input-group>
                            <x-input-group
                                type="text"
                                id="contact.city"
                                name="contact.city"
                                wire:model.lazy="contact.city"
                                labelText="City"
                            />
                            <x-input-group
                                type="text"
                                id="contact.postalcode"
                                name="contact.postalcode"
                                wire:model.lazy="contact.postalcode"
                                labelText="Postal code"
                            />
                            <x-input-group
                                type="text"
                                id="contact.address_line_1"
                                name="contact.address_line_1"
                                wire:model.lazy="contact.address_line_1"
                                labelText="Address line 1"
                            />
                            <x-input-group
                                type="text"
                                id="contact.address_line_2"
                                name="contact.address_line_2"
                                wire:model.lazy="contact.address_line_2"
                                labelText="Address line 2"
                            />
                        </div>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
