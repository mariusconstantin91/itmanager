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
                @if ($this->document->approved_by_id)
                    <p class="w-32 mr-4 pt-2 text-sm text-green-700">Approved by {{ isset($this->document->approveUser) ? $this->document->approveUser->name : auth()->user()->name }}</p>
                @elseif ($this->document->status == 'rejected')
                    <p class="w-32 mr-4 pt-2 text-sm text-red-700"> Rejected </p>
                @elseif ($this->document->status == 'pending' && !auth()->user()->hasRole('user'))    
                    <button
                        type="button"
                        class="rounded-lg bg-green-600 py-2 px-5 pb-2.5 mr-4 text-sm font-medium text-white hover:bg-green-700"
                        wire:click.prevent="approveDocument()"
                    >
                        Approve Document <i class="fa-solid fa-check ml-2 mt-1"></i>
                    </button>
                    
                    <button
                        type="button"
                        class="rounded-lg bg-red-600 py-2 px-5 pb-2.5 mr-4 text-sm font-medium text-white hover:bg-red-700"
                        wire:click.prevent="rejectDocument()"
                    >
                        Reject Document <i class="fa-solid fa-xmark ml-2 mt-1"></i>
                    </button>
                @endif
                <a
                    class="mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
                    href="{{ route('documents.index') }}"
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
                            <input type="hidden" wire:model.lazy="document.approved_by_id">
                            <x-input-group
                                type="text"
                                id="document.name"
                                name="document.name"
                                wire:model.lazy="document.name"
                                labelText="Name"
                            />
                            <x-input-group
                                type="text"
                                id="document.type"
                                name="document.type"
                                wire:model.lazy="document.type"
                                labelText="Type"
                            />
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->document->user,
                                )->name"
                                placeholder="Start typing"
                                id="document.user_id"
                                name="document.user_id"
                                wire:model.lazy="document.user_id"
                                labelText="User"
                                functionOptions="userUpdated"
                            />                            
                            <x-input-group
                                type="file"
                                id="file"
                                name="file"
                                wire:model.lazy="file"
                                labelText="File"
                            />
                            @if ($this->document->path)
                                <a class=" text-blue-800 pt-4" target="_blank" href="{{ asset('storage/' . $this->document->path) }}">{{ $this->document->path }}</a>
                            @endif
                        </div>
                    </x-panel>
                </div>
            </div>
        </div>
    </form>
</div>
