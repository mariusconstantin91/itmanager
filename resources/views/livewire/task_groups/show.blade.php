<div>
    <div class="align-start mb-4 flex">
        <h1 class="text-3xl font-semibold text-black-500">
            Task Group #{{ $this->taskGroup->id }} - {{ $this->taskGroup->name  }}
        </h1>
    </div>
    <div class="main-content mb-16">
        <div class="flex flex-wrap">
            <div class="w-full">
                <x-panel label="Tasks" wrapperExtraClasses="mt-6">
                    <div x-data="{ showFilters: false }">
                        <div class="mb-4 flex items-end">
                            <span class="mr-5 rounded-md">
                                <button
                                    type="button"
                                    class="text-black rounded-lg bg-gray-200 px-4 py-2.5 text-sm font-medium"
                                    :class="{ 'bg-gray-400': showFilters }"
                                    @click="showFilters = !showFilters;"
                                >
                                    <i class="fa-solid fa-filter mr-3"></i> Filters
                                </button>
                            </span>
                            <livewire:datatable::search :datatable-class="$datatableTasks" />
                        </div>
                
                        <div x-show="showFilters">
                            <livewire:datatable::filters
                                :datatable-class="$datatableTasks"
                                :title="'Filters'"
                            />
                        </div>
                        <x-datatable::layout :datatable-class="$datatableTasks">
                        </x-datatable::layout>
                    </div>
                </x-panel>                         
            </div>
        </div>
    </div>
</div>
