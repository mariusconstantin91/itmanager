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
            <div class="ml-auto w-auto flex-nowrap flex">
                @if ($this->holiday->approved_by_id)
                    <p class="w-32 mr-4 pt-2 text-sm text-green-700">Approved by {{ isset($this->holiday->approveUser) ? $this->holiday->approveUser->name : auth()->user()->name }}</p>
                @elseif ($this->holiday->status == 'rejected')
                    <p class="w-32 mr-4 pt-2 text-sm text-red-700"> Rejected </p>
                @elseif ($this->holiday->status == 'pending' && !auth()->user()->hasRole('user'))    
                    <button
                        type="button"
                        class="rounded-lg bg-green-600 py-2 px-5 pb-2.5 mr-4 text-sm font-medium text-white hover:bg-green-700"
                        wire:click.prevent="approveHoliday()"
                    >
                        Approve Holiday <i class="fa-solid fa-check ml-2 mt-1"></i>
                    </button>
                    
                    <button
                        type="button"
                        class="rounded-lg bg-red-600 py-2 px-5 pb-2.5 mr-4 text-sm font-medium text-white hover:bg-red-700"
                        wire:click.prevent="rejectHoliday()"
                    >
                        Reject Holiday <i class="fa-solid fa-xmark ml-2 mt-1"></i>
                    </button>
                @endif
                <a
                    class="mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
                    href="{{ route('holidays.index') }}"
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
                            <input type="hidden" wire:model.lazy="holiday.approved_by_id">
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->holiday->user,
                                )->name"
                                placeholder="Start typing"
                                id="holiday.user_id"
                                name="holiday.user_id"
                                wire:model.lazy="holiday.user_id"
                                labelText="User"
                                functionOptions="userUpdated"
                            />
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d',
                                ]"
                                required
                                id="holiday.start_date"
                                name="holiday.start_date"
                                wire:model.lazy="holiday.start_date"
                                type="datepicker"
                                placeholder='Start Date'
                                labelText="Start Date"
                            />
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d',
                                ]"
                                required
                                id="holiday.end_date"
                                name="holiday.end_date"
                                wire:model.lazy="holiday.end_date"
                                type="datepicker"
                                placeholder='End Date'
                                labelText="End Date"
                            />
                            <x-input-group
                                type="text"
                                id="holiday.note"
                                name="holiday.note"
                                wire:model.lazy="holiday.note"
                                labelText="Note"
                            />
                        </div>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
