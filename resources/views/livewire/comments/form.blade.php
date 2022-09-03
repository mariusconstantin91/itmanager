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
                    href="{{ route('comments.index') }}"
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
                                    $this->comment->user,
                                )->name"
                                placeholder="Start typing"
                                id="comment.user_id"
                                name="comment.user_id"
                                wire:model.lazy="comment.user_id"
                                labelText="User"
                                functionOptions="userUpdated"
                            />
                            <x-input-group
                                type="search-dropdown-extended"
                                :initialText="optional(
                                    $this->comment->task,
                                )->name"
                                placeholder="Start typing"
                                id="comment.task_id"
                                name="comment.task_id"
                                wire:model.lazy="comment.task_id"
                                labelText="Task"
                                functionOptions="taskUpdated"
                            />
                            <x-input-group
                                type="text"
                                id="comment.comment"
                                name="comment.comment"
                                wire:model.lazy="comment.comment"
                                labelText="Comment"
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
