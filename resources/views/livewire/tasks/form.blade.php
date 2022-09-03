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
                    href="{{ route('tasks.index') }}"
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
                                    $this->task->project,
                                )->name"
                                placeholder="Start typing"
                                id="task.project_id"
                                name="task.project_id"
                                wire:model.lazy="task.project_id"
                                labelText="Project"
                                wrapperClass="col-span-3"
                                functionOptions="projectUpdated"
                            />
                            <x-input-group
                                type="text"
                                id="task.name"
                                name="task.name"
                                wire:model.lazy="task.name"
                                labelText="Name"
                                required
                                wrapperClass="col-start-1 col-end-2"
                            />
                            <x-input-group
                                type="select-formated"
                                id="task.status"
                                name="task.status"
                                wire:model="task.status"
                                labelText="Status"
                                :options="$statusOptions"
                                optionsProperty="statusOptions"
                                
                            />
                            <x-input-group
                                type="select-formated"
                                id="task.priority"
                                name="task.priority"
                                wire:model="task.priority"
                                labelText="Priority"
                                :options="$importanceOptions"
                                optionsProperty="importanceOptions"
                            />
                            <x-input-group
                                type="number-buttons"
                                id="task.estimate"
                                name="task.estimate"
                                wire:model.lazy="task.estimate"
                                labelText="Estimate"
                            />
                            <x-input-group
                                type="select-formated"
                                id="task.story_points"
                                name="task.story_points"
                                wire:model="task.story_points"
                                labelText="Story points"
                                :options="$storyPointsOptions"
                                optionsProperty="storyPointsOptions"
                            />
                            <x-input-group
                                :datepicker-config="[
                                    'dateFormat' => 'Y-m-d',
                                ]"
                                required
                                id="task.deadline"
                                name="task.deadline"
                                wire:model.lazy="task.deadline"
                                type="datepicker"
                                placeholder='Deadline'
                                labelText="Deadline"
                            />
                            <div>
                                <x-input-group
                                    type="select-formated-multi"
                                    id="users"
                                    input="userInput"
                                    name="userIds"
                                    wire:model="userIds"
                                    labelText="Users"
                                    :options="$userOptions"
                                    optionsProperty="userOptions"
                                />
                                @if ($this->task->project_id && count($this->skillItems) && $this->skillItems[0]['name'] && $this->skillItems[0]['importance'])
                                    <x-tasks-suggest-user />
                                @endif
                            </div>
                            
                            <x-input-group
                                type="select-formated-multi"
                                id="taskGroupIds"
                                input="taskGroupInput"
                                name="taskGroupIds"
                                wire:model="taskGroupIds"
                                labelText="Task groups"
                                :options="$taskGroupOptions"
                                optionsProperty="taskGroupOptions"
                            />
                            <x-input-group
                                type="textarea"
                                placeholder=""
                                id="description"
                                name="task.description"
                                required="required"
                                wire:model.lazy="task.description"
                                labelText="Description"
                                rows="10"
                                wrapperClass="col-span-3"
                            />
                        </div>
                    </x-panel>
                    <x-panel label="Tags" wrapperExtraClasses="mt-8">
                        <ul class="mb-6">
                            @forelse($this->tagItems as $key => $tagItem)
                                <li class="mb-4 grid grid-cols-3 gap-4 w-full">
                                    <x-input-group
                                        type="search-dropdown-extended"
                                        :initialText="$tagItem['name']"
                                        placeholder="Start typing"
                                        id="tagItems.{{ $key }}.name"
                                        name="tagItems.{{ $key }}.name"
                                        wire:model.lazy="tagItems.{{ $key }}.name"
                                        labelText="Tag"
                                        functionOptions="tagUpdated"
                                    />
                                    <x-input-group
                                        type="select-formated"
                                        id="tagItems.{{ $key }}.importance"
                                        name="tagItems.{{ $key }}.importance"
                                        wire:model="tagItems.{{ $key }}.importance"
                                        labelText="Importance"
                                        :options="$importanceOptions"
                                        optionsProperty="importanceOptions"
                                    />
                                    <x-delete-button
                                        :key="$key"
                                        function="deleteTagLine"
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
                            wire:click.prevent="addTagNewLine"
                        >
                            Add Tag <i class="fa-solid fa-plus ml-2"></i>
                        </button>
                    </x-panel>
                    <x-panel label="Skills Needed" wrapperExtraClasses="mt-8">
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
                                        labelText="Importance"
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
                </div>
            </div>
        </div>
    </form>
</div>
