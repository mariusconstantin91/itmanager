<div>
    <div class="align-start mb-4 flex">
        <h1 class="text-3xl font-semibold text-black-500">
            Task #{{ $this->task->id }} - {{ $this->task->name  }}
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
                                    <td class="px-1"><span class="font-medium">Name:</span></td>
                                    <td class="px-1"> {{ $this->task->name }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Project:</span></td>
                                    <td class="px-1"> <a class="text-blue-500" href="{{ route('projects.show', ['project' => $this->task->project->id]) }}">{{ $this->task->project->name }} </a> </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Status:</span></td>
                                    <td class="px-1"> {{ ucwords(str_replace('_', ' ', $this->task->status)) }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Priority:</span></td>
                                    <td class="px-1"> {{ \App\Models\Task::PRIORITY_OPTIONS[$this->task->priority] }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Estimate:</span> </td>
                                    <td class="px-1">{{ intdiv($this->task->estimate, 60) . ':' .  ($this->task->estimate % 60) }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Tracked Time:</span> </td>
                                    <td class="px-1">{{ intdiv($trackedTime, 60) . ':' .  ($trackedTime % 60) }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Deadline:</span> </td>
                                    <td class="px-1">{{ $this->task->deadline }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Story points:</span></td>
                                    <td class="px-1"> {{ $this->task->story_points }} </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <div class="mb-2">
                                <h2 class="mb-2 text-lg font-medium">Task Groups</h2>
                                @if ($this->task->taskGroups->count())
                                    <ul>
                                        @forelse($this->task->taskGroups as $taskGroup)
                                            <li wire:key="task-groups-{{ $taskGroup->id }}">
                                                <a href="{{ route('task_groups.show', ['taskGroup' => $taskGroup->id]) }}" class="text-blue-500">{{ $taskGroup->name}}</a>
                                            </li>
                                        @empty
                                            <li>No task groups</li>
                                        @endforelse
                                    </ul>
                                @else
                                    -
                                @endif
                            </div>
                            <div class="mb-2">
                                <h2 class="mb-2 text-lg font-medium">Skills Needed</h2>
                                @if ($this->task->skills->count())
                                    <x-skills :entities="$this->task->skills"/>
                                @else
                                    -
                                @endif
                            </div>
                            <div class="mb-2">
                                <h2 class="mb-2 text-lg font-medium">Tags</h2>
                                @if ($this->task->tags->count())
                                    <x-skills :entities="$this->task->tags"/>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </x-panel>
                <x-panel label="Users" wrapperExtraClasses="mt-6">
                    <livewire:datatable::datatable :datatable-class="$datatableUsers">
                    </livewire:datatable::datatable wire:key="users-datatable">
                </x-panel>
                <x-panel label="Add time entry" wrapperExtraClasses="mt-6">
                    <div x-data="{ showSuccessAlert: 'true' }">
                        <x-alerts.success :message="session()->get('messageTimeEntry')"/>
                    </div>
                    <div class="grid grid-cols-7 gap-3">
                        <x-input-group
                            :datepicker-config="[
                                'dateFormat' => 'Y-m-d H:i',
                                'enableTime' => true,
                                'time_24hr' => true,
                            ]"
                            required
                            id="newTimeEntry.start_at"
                            name="newTimeEntry.start_at"
                            wire:model.lazy="newTimeEntry.start_at"
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
                            id="newTimeEntry.end_at"
                            name="newTimeEntry.end_at"
                            wire:model.lazy="newTimeEntry.end_at"
                            type="datepicker"
                            placeholder='End At'
                            labelText="End At"
                        />
                        <x-input-group
                            type="text"
                            id="newTimeEntry.description"
                            name="newTimeEntry.description"
                            wire:model.lazy="newTimeEntry.description"
                            labelText="Description"
                            wrapperClass="col-span-4"
                            required
                        />
                        <div>
                            <button
                                type="button"
                                class="mt-3 ml-auto focus:ring-red flex w-auto justify-center rounded-lg bg-gray-900 px-4 py-2 text-xs font-medium text-white transition duration-150 ease-in-out hover:bg-green-700 focus:border-green-700 focus:outline-none active:bg-green-700"
                                wire:click="addTimeEntry"
                            >
                                Add Time entry
                            </button>
                        </div>
                    </div>
                </x-panel>
                <x-panel label="Time Entries" wrapperExtraClasses="mt-6">
                    <livewire:datatable::datatable :datatable-class="$datatableTimeEntries">
                    </livewire:datatable::datatable wire:key="time-entries-datatable">
                </x-panel>
                <x-panel label="Description" wrapperExtraClasses="mt-6">
                    {{ $this->task->description }}
                </x-panel>
                <x-panel label="Comments" wrapperExtraClasses="mt-6">
                    <x-comments :comments="$this->comments" addFunction="addComment" deleteFunction="deleteComment"/>
                </x-panel>                 
            </div>
        </div>
    </div>
</div>
