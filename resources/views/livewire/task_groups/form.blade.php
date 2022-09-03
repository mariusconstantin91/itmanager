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
                    href="{{ route('task_groups.index') }}"
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
                        <div class="max-w-64 grid grid-cols-1 gap-4">
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->taskGroup->project,
                                )->name"
                                placeholder="Start typing"
                                id="taskGroup.project_id"
                                name="taskGroup.project_id"
                                wire:model.lazy="taskGroup.project_id"
                                labelText="Project"
                                functionOptions="projectUpdated"
                            />
                            <x-input-group
                                type="text"
                                placeholder=""
                                id="taskGroup.name"
                                name="taskGroup.name"
                                required="required"
                                wire:model.lazy="taskGroup.name"
                                labelText="Name"
                            /> 
                            <x-input-group
                                type="textarea"
                                placeholder=""
                                id="description"
                                name="taskGroup.description"
                                required="required"
                                wire:model.lazy="taskGroup.description"
                                labelText="Description"
                                rows="10"
                            />
                        </div>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
