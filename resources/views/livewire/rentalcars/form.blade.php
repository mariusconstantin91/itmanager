<div x-data="{ showSuccessAlert: 'true' }">
    <form
        wire:submit.prevent="save"
        id="actions-form"
    >
        @csrf
        <header class="mb-6 flex items-center">
            <h2 class="text-2xl font-semibold text-black-500">
                {{ $title }}
            </h2>
            <x-input-group
                type="switch"
                id="rentalCar.active"
                name="rentalCar.active"
                wire:model.lazy="rentalCar.active"
                label="Active"
                wrapperClass="ml-8"
            />
            <a
                href="{{ route('rentalcars.index') }}"
                class="ml-auto mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
            >
                Cancel
            </a>
            <button
                type="submit"
                wire:loading.attr="disabled"
                @click="showSuccessAlert = true;"
                class="rounded-lg bg-gray-900 py-2 px-5 pb-2.5 text-sm font-medium text-white hover:bg-green-700"
            >
                Save
            </button>
        </header>
        <div class="main-content mb-16">
            <x-alerts.success />

            <x-panel
                label="Info"
                wrapperExtraClasses="mb-5"
            >
                <x-input-group
                    type="text"
                    id="rentalCar.name"
                    name="rentalCar.name"
                    wire:model.lazy="rentalCar.name"
                    labelText="Name"
                    wrapperClass="mb-6"
                    required
                />

                <div class="flex">
                    <x-input-group
                        type="select"
                        id="rentalCar.provider_id"
                        name="rentalCar.provider_id"
                        wire:model.lazy="rentalCar.provider_id"
                        labelText="Provider"
                        :options="$this->providerOptions"
                        selected="Select"
                        wrapperClass="flex-1"
                        required
                    />

                    <x-input-group
                        type="text"
                        id="rentalCar.pax"
                        name="rentalCar.pax"
                        wire:model.lazy="rentalCar.pax"
                        labelText="PAX"
                        wrapperClass="ml-4"
                        required
                    />
                </div>
            </x-panel>

            <x-panel
                label="Pricing"
                wrapperExtraClasses="mb-5"
            >

                <div class="mb-6 flex">
                    <x-input-group
                        type="select"
                        id="rentalCar.currency_id"
                        name="rentalCar.currency_id"
                        wire:model.lazy="rentalCar.currency_id"
                        labelText="Currency"
                        :options="$this->currencyOptions"
                        selected="Select"
                        required
                    />

                    <x-input-group
                        type="text"
                        id="rentalCar.price"
                        name="rentalCar.price"
                        wire:model.lazy="rentalCar.price"
                        labelText="Price"
                        wrapperClass="flex-1 ml-4"
                        required
                    />

                    <x-input-group
                        type="text"
                        id="rentalCar.price_peak"
                        name="rentalCar.price_peak"
                        wire:model.lazy="rentalCar.price_peak"
                        labelText="Price (Peak)"
                        wrapperClass="flex-1 ml-4"
                        required
                    />
                </div>

                <div class="flex">
                    <x-input-group
                        type="text"
                        id="rentalCar.insurance"
                        name="rentalCar.insurance"
                        wire:model.lazy="rentalCar.insurance"
                        labelText="Insurance"
                        wrapperClass="flex-1"
                        required
                    />

                    <x-input-group
                        type="text"
                        id="rentalCar.assistance"
                        name="rentalCar.assistance"
                        wire:model.lazy="rentalCar.assistance"
                        labelText="Assistance"
                        wrapperClass="flex-1 ml-4"
                        required
                    />

                    <x-input-group
                        type="text"
                        id="rentalCar.margin"
                        name="rentalCar.margin"
                        wire:model.lazy="rentalCar.margin"
                        labelText="Margin"
                        wrapperClass="flex-1 ml-4"
                        required
                    />
                </div>
            </x-panel>

            <x-panel
                label="Return Fees"
                contentClasses="bg-white p-4"
            >
                <ul class="mb-6">
                    @forelse($this->returnFeeItems as $key => $rentalCarReturnFee)
                        <li class="mb-4 flex items-center gap-4">
                            <x-input-group
                                type="select"
                                id="returnFeeItems.{{ $key }}.pick_up_location_id"
                                name="returnFeeItems.{{ $key }}.pick_up_location_id"
                                wire:model.lazy="returnFeeItems.{{ $key }}.pick_up_location_id"
                                :options="$this->locationOptions"
                                labelText="Pickup"
                                selected="Select"
                                wrapperClass="flex-1"
                                required
                            />
                            <x-input-group
                                type="select"
                                id="returnFeeItems.{{ $key }}.drop_off_location_id"
                                name="returnFeeItems.{{ $key }}.drop_off_location_id"
                                wire:model.lazy="returnFeeItems.{{ $key }}.drop_off_location_id"
                                :options="$this->locationOptions"
                                labelText="Dropoff"
                                selected="Select"
                                wrapperClass="flex-1"
                                required
                            />
                            <x-input-group
                                type="text"
                                id="returnFeeItems.{{ $key }}.fee"
                                name="returnFeeItems.{{ $key }}.fee"
                                wire:model.lazy="returnFeeItems.{{ $key }}.fee"
                                labelText="Fee"
                                wrapperClass="w-20"
                                required
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
                    Add Return Fee <i class="fa-solid fa-plus ml-2"></i>
                </button>
            </x-panel>
        </div>
    </form>
</div>
