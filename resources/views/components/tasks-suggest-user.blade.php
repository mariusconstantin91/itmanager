<div x-data="{ showSugestionModal: false }">
    <button
        type="button"
        @click="showSugestionModal = true"
        class="mt-2 focus:ring-red flex w-auto justify-center rounded-lg bg-gray-900 px-4 py-2 text-xs font-medium text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:border-gray-700 focus:outline-none active:bg-gray-700"
    >
        Show sugestions
    </button>

    <div x-cloak>
        <div
            x-show="showSugestionModal"
            class="fixed top-0 bottom-0 left-0 right-0 z-50 flex items-center justify-center overflow-auto bg-gray-900 bg-opacity-90"
            x-transition:enter="transition ease duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div
                x-show="showSugestionModal"
                @click.away="showSugestionModal = !showSugestionModal; $wire.closeSuggestionsModal()"
                class="shadow-black w-2/4 rounded-lg border border-gray-200 bg-white shadow-sm"
                x-transition:enter="transition ease duration-100 transform"
                x-transition:enter-start="opacity-0 scale-90 translate-y-1"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease duration-100 transform"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-1"
            >
                <div
                    class="flex cursor-pointer items-center border-b border-gray-200 bg-gray-50 px-8 py-4">
                    <span
                        class="block whitespace-nowrap text-xl font-semibold text-black-500"
                    >
                        Suggested users
                    </span>
                    <div
                        class="ml-auto cursor-pointer align-middle text-xl font-semibold text-black-500"
                        @click="showSugestionModal = !showSugestionModal; $wire.closeSuggestionsModal()"
                    >
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="px-8 py-4">
                    <div class="mt-2 mb-6 text-base font-normal text-gray-600">
                        <x-input-group
                            type="select-formated-multi"
                            id="suggestionsRelatedTaskId"
                            input="suggestionsRelatedTasksInput"
                            name="suggestionsRelatedTaskId"
                            wire:model="suggestionsRelatedTaskId"
                            labelText="Select related tasks from project"
                            :options="$this->suggestedRelatedTaskOptions"
                            optionsProperty="suggestedRelatedTaskOptions"
                            wrapperClass="mt-3"
                        />
                        <x-input-group
                            type="select-formated-multi"
                            id="suggestionsProjectsId"
                            input="suggestionsProjectInput"
                            name="suggestionsProjectsId"
                            wire:model="suggestionsProjectsId"
                            labelText="Select projects from where additional users can be taken"
                            :options="$this->suggestedProjectOptions"
                            optionsProperty="suggestedProjectOptions"
                            wrapperClass="mt-3"
                        />
                    </div>
                    <div>
                        <h3 class="font-medium mb-3 font-lg">Scoring users:</h3>
                        <div wire:loading wire:target="makeSuggestions">
                            Searching...
                        </div>
                        <ul wire:loading.remove wire:target="makeSuggestions">
                            @forelse($this->usersWithScore as $userSuggested)
                            
                                <li class="mb-1.5">User #{{ $userSuggested['user']['id'] }} {{ $userSuggested['user']['name'] }} - Score: {{ $userSuggested['score'] }}</li>
                            @empty
                                <li class="mb-1.5"> No users </li>
                            @endforelse
                        </ul>
                    </div>
    
                    <div class="mt-9 flex justify-end">
                        <button
                            type="button"
                            @click="showSugestionModal = !showSugestionModal; $wire.closeSuggestionsModal()"
                            class="mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
                        >
                           Close
                        </button>
                        <button
                            type="button"
                            wire:click='makeSuggestions()'
                            class="rounded-lg bg-gray-900 py-2 px-5 pb-2.5 text-sm font-medium text-white hover:bg-green-700"
                        >
                            Make sugestions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>