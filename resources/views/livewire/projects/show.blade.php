<div>
    <div class="align-start mb-4 flex">
        <h1 class="text-3xl font-semibold text-black-500">
            Project #{{ $this->project->id }} - {{ $this->project->name  }}
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
                                    <td class="px-1"> {{ $this->project->name }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Client:</span></td>
                                    <td class="px-1"> <a class="text-blue-500" href="{{ route('clients.show', ['client' => $this->project->client_id]) }}"> {{ optional($this->project->client)->name }} </a></td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Imporance:</span></td>
                                    <td class="px-1"> {{ \App\Models\Task::PRIORITY_OPTIONS[$this->project->importance] }}</td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Status:</span></td>
                                    <td class="px-1"> {{ ucwords(str_replace('_', ' ', $this->project->status)) }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Start Date:</span></td>
                                    <td class="px-1"> {{ $this->project->start_date }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Deadline Date:</span></td>
                                    <td class="px-1"> {{ $this->project->deadline_date }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Soft Deadline Date:</span></td>
                                    <td class="px-1"> {{ $this->project->soft_deadline_date }} </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Budget:</span> </td>
                                    <td class="px-1">{{ $this->project->budget }} $ </td>
                                </tr>
                                <tr class="my-2.5">
                                    <td class="px-1"><span class="font-medium">Tracked Time:</span> </td>
                                    <td class="px-1">{{ intdiv($trackedTime, 60) . ':' .  ($trackedTime % 60) }} </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <div class="mb-2">
                                <h2 class="mb-2 text-lg font-medium">Task Groups</h2>
                                @if ($taskGroups->count())
                                    <ul>
                                        @forelse($taskGroups as $taskGroup)
                                            <li>
                                                <a href="{{ route('taskGroups.show', [taskGroup => $taskGroup->id]) }}" class="text-blue-500">{{ $taskGroup->name}}</a>
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
                                <h2 class="mb-2 text-lg font-medium">Skills</h2>
                                @if ($this->project->skills->count())
                                    <x-skills :entities="$this->project->skills"/>
                                @else
                                    -
                                @endif
                            </div>
                            <div class="mb-2">
                                <h2 class="mb-2 text-lg font-medium">Tags</h2>
                                @if ($this->project->tags->count())
                                    <x-skills :entities="$this->project->tags"/>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </x-panel>
                <x-panel label="Users" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableUsers">
                    </x-datatable::layout>
                </x-panel>

                <x-panel label="Time Entries" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableTimeEntries">
                    </x-datatable::layout>
                </x-panel>

                <x-panel label="Tasks" wrapperExtraClasses="mt-6">
                    <x-datatable::layout :datatable-class="$datatableTaskEntries">
                    </x-datatable::layout>
                </x-panel>                         
            </div>
        </div>
    </div>
</div>
