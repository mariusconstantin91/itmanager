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
                    href="{{ route('users.index') }}"
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
                                type="text"
                                id="user.name"
                                name="user.name"
                                wire:model.lazy="user.name"
                                labelText="Name"
                                required
                            />
                            <x-input-group
                                type="select-formated"
                                id="user.role_id"
                                name="user.role_id"
                                wire:model="user.role_id"
                                labelText="Role"
                                :options="$rolesOptions"
                                optionsProperty="rolesOptions"
                            />
                            <x-input-group
                                type="text"
                                id="user.position"
                                name="user.position"
                                wire:model.lazy="user.position"
                                labelText="Position"
                            />
                            <x-input-group
                                type="phone"
                                id="user.phone"
                                name="user.phone"
                                wire:model.lazy="user.phone"
                                labelText="Phone"
                                required
                            />
                            <x-input-group
                                type="email"
                                id="user.email"
                                name="user.email"
                                wire:model.lazy="user.email"
                                labelText="Email"
                                required
                            />
                            <x-input-group
                                type="text"
                                id="user.salary"
                                name="user.salary"
                                wire:model.lazy="user.salary"
                                labelText="Salary($)"
                                required
                            />
                            <x-input-group
                                type="password"
                                id="password"
                                name="password"
                                wire:model.lazy="password"
                                labelText="Password"
                                required
                            />
                            <x-input-group
                                type="password"
                                id="passwordConfirmation"
                                name="passwordConfirmation"
                                wire:model.lazy="passwordConfirmation"
                                labelText="Password Confirmed"
                                required
                            />
                        </div>
                    </x-panel>
                    <x-panel label="Address" wrapperExtraClasses="mt-8">
                        <div class="grid grid-cols-3 gap-4">
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->user->country,
                                )->name"
                                placeholder="Start typing"
                                id="user.country_id"
                                name="user.country_id"
                                wire:model.lazy="user.country_id"
                                labelText="Country"
                                functionOptions="countryUpdated"
                            > </x-input-group>
                            <x-input-group
                                type="text"
                                id="user.city"
                                name="user.city"
                                wire:model.lazy="user.city"
                                labelText="City"
                            />
                            <x-input-group
                                type="text"
                                id="user.postalcode"
                                name="user.postalcode"
                                wire:model.lazy="user.postalcode"
                                labelText="Postal code"
                            />
                            <x-input-group
                                type="text"
                                id="user.address_line_1"
                                name="user.address_line_1"
                                wire:model.lazy="user.address_line_1"
                                labelText="Address line 1"
                            />
                            <x-input-group
                                type="text"
                                id="user.address_line_2"
                                name="user.address_line_2"
                                wire:model.lazy="user.address_line_2"
                                labelText="Address line 2"
                            />
                        </div>
                    </x-panel>
                    <x-panel label="Skills" wrapperExtraClasses="mt-8">
                        <ul class="mb-6">
                            
                            @forelse($this->skillItems as $key => $skillItem)
                                <li class="mb-4 grid grid-cols-3 gap-4 w-full">
                                    <x-input-group
                                        type="search-dropdown-extended"
                                        :initialText="$skillItem['name']"
                                        placeholder="Start typing"
                                        id="skillItems.{{ $key }}.name"
                                        name="skillItems.{{ $key }}.name"
                                        wire:model.lazy="skillItems.{{ $key }}.name"
                                        labelText="Skill"
                                        functionOptions="skillUpdated"
                                    />
                                    <x-input-group
                                        type="select-formated"
                                        id="skillItems.{{ $key }}.importance"
                                        name="skillItems.{{ $key }}.importance"
                                        wire:model="skillItems.{{ $key }}.importance"
                                        labelText="Level"
                                        :options="$importanceOptions"
                                        optionsProperty="importanceOptions"
                                    />
                                    <x-delete-button
                                        :key="$key"
                                        function="deleteSkillLine"
                                        class="mt-4"
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
                            wire:click.prevent="addSkillNewLine"
                        >
                            Add Skill <i class="fa-solid fa-plus ml-2"></i>
                        </button>
                    </x-panel>
                    <x-panel label="Holidays" wrapperExtraClasses="mt-8">
                        <ul class="mb-6">
                            @forelse($this->holidayItems as $key => $holidayItem)
                                <li class="mb-4 grid grid-cols-3 gap-4 w-full">
                                    <x-input-group
                                        required
                                        id="holidayItems.{{ $key }}.start_date"
                                        name="holidayItems.{{ $key }}.start_date"
                                        wire:model.lazy="holidayItems.{{ $key }}.start_date"
                                        type="text"
                                        placeholder='Start Date'
                                        labelText="Start Date"
                                    />
                                    <x-input-group
                                        required
                                        id="holidayItems.{{ $key }}.end_date"
                                        name="holidayItems.{{ $key }}.end_date"
                                        wire:model.lazy="holidayItems.{{ $key }}.end_date"
                                        type="text"
                                        placeholder='End Date'
                                        labelText="End Date"
                                    />
                                    <x-input-group
                                        type="select-formated"
                                        id="holidayItems.{{ $key }}.status"
                                        name="holidayItems.{{ $key }}.status"
                                        wire:model="holidayItems.{{ $key }}.status"
                                        labelText="Status"
                                        :options="$statusOptions"
                                        optionsProperty="statusOptions"
                                    />
                                    <x-input-group
                                        type="text"
                                        id="holidayItems.{{ $key }}.note"
                                        name="holidayItems.{{ $key }}.note"
                                        wire:model.lazy="holidayItems.{{ $key }}.note"
                                        labelText="Note"
                                    />
                                    <div class="flex">
                                    @if ($holidayItem['approved_by_id'])
                                        <p class="mr-4 mt-4 text-sm text-green-700">Approved by {{$holidayItem['approved_by_name'] }}</p>
                                    @else
                                        
                                            <button
                                                type="button"
                                                class="focus:ring-gray flex w-auto justify-center rounded-lg bg-green-600 px-4 py-2 text-xs font-medium text-white transition duration-150 ease-in-out hover:bg-green-700 focus:border-green-700 focus:outline-none active:bg-green-700 mr-4 mt-4 h-auto"
                                                wire:click.prevent="approveHolidayLine({{ $key }})"
                                            >
                                                Approve Holiday <i class="fa-solid fa-check ml-2 mt-1"></i>
                                            </button>
                                        
                                    @endif
                                    <x-delete-button
                                        :key="$key"
                                        function="deleteHolidayLine"
                                        class="mt-4"
                                    />
                                    </div>
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
                            wire:click.prevent="addHolidayNewLine"
                        >
                            Add Holiday <i class="fa-solid fa-plus ml-2"></i>
                        </button>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
