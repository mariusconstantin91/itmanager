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
                    href="{{ route('time_entries.index') }}"
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
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->timeEntry->user,
                                )->name"
                                placeholder="Start typing"
                                id="timeEntry.user_id"
                                name="timeEntry.user_id"
                                wire:model.lazy="timeEntry.user_id"
                                labelText="User"
                                functionOptions="userUpdated"
                            />
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->timeEntry->project,
                                )->name"
                                placeholder="Start typing"
                                id="timeEntry.project_id"
                                name="timeEntry.project_id"
                                wire:model.lazy="timeEntry.project_id"
                                labelText="Project"
                                functionOptions="projectUpdated"
                            />
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->timeEntry->task,
                                )->name"
                                placeholder="Start typing"
                                id="timeEntry.task_id"
                                name="timeEntry.task_id"
                                wire:model.lazy="timeEntry.task_id"
                                labelText="Task"
                                functionOptions="taskUpdated"
                            />
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d H:i',
                                    'enableTime' => true,
                                    'time_24hr' => true,
                                ]"
                                required
                                id="startAt"
                                name="startAt"
                                wire:model.lazy="startAt"
                                type="datepicker"
                                placeholder='Start At'
                                labelText="Start At"
                            />
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d H:i',
                                    'enableTime' => true,
                                    'time_24hr' => true,
                                ]"
                                required
                                id="endAt"
                                name="endAt"
                                wire:model.lazy="endAt"
                                type="datepicker"
                                placeholder='End At'
                                labelText="End At"
                            />
                            <x-input-group
                                type="text"
                                disabled="disabled"
                                id="duration"
                                name="duration"
                                wire:model.lazy="duration"
                                labelText="Duration"
                            />
                            <x-input-group
                                type="text"
                                id="timeEntry.description"
                                name="timeEntry.description"
                                wire:model.lazy="timeEntry.description"
                                labelText="Description"
                                wrapperClass="col-span-3 col-start-1"
                                required
                            />
                        </div>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
