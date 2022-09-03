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
                    href="{{ route('projects.index') }}"
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
                                id="project.name"
                                name="project.name"
                                wire:model.lazy="project.name"
                                labelText="Name"
                                required
                            />
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->project->client,
                                )->name"
                                placeholder="Start typing"
                                id="project.client_id"
                                name="project.client_id"
                                wire:model.lazy="project.client_id"
                                labelText="Client"
                                functionOptions="clientUpdated"
                            > </x-input-group>
                            <x-input-group
                                type="select-formated"
                                id="project.importance"
                                name="project.importance"
                                wire:model="project.importance"
                                labelText="Importance"
                                :options="$importanceOptions"
                                optionsProperty="importanceOptions"
                            > </x-input-group>
                            <x-input-group
                                type="select-formated"
                                id="project.status"
                                name="project.status"
                                wire:model="project.status"
                                labelText="Status"
                                :options="$statusOptions"
                                optionsProperty="statusOptions"
                            > </x-input-group>
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d',
                                ]"
                                required
                                id="project.start_date"
                                name="project.start_date"
                                wire:model.lazy="project.start_date"
                                type="datepicker"
                                placeholder='Start Date'
                                labelText="Start Date"
                            />
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d',
                                ]"
                                required
                                id="project.soft_deadline_date"
                                name="project.soft_deadline_date"
                                wire:model.lazy="project.soft_deadline_date"
                                type="datepicker"
                                placeholder='Soft Deadline Date'
                                labelText="Soft DeadLine Date"
                            />
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d',
                                ]"
                                required
                                id="project.deadline_date"
                                name="project.deadline_date"
                                wire:model.lazy="project.deadline_date"
                                type="datepicker"
                                placeholder='Deadline Date'
                                labelText="DeadLine Date"
                            />
                            <x-input-group
                                type="number"
                                id="project.budget"
                                name="project.budget"
                                wire:model.lazy="project.budget"
                                labelText="Budget"
                                step="0.01"
                            />
                            <x-input-group
                                type="select-formated-multi"
                                id="users"
                                input="userInput"
                                name="userIds"
                                wire:model="userIds"
                                labelText="Users"
                                :options="$userOptions"
                                optionsProperty="userOptions"
                                wrapperClass="col-span-full"
                            > </x-input-group>
                        </div>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
