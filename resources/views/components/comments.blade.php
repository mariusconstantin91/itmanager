@props(['comments', 'deleteFunction', 'addFunction'])

<div class="flex flex-wrap w-full">
    <ul class="w-full">
        @foreach($comments as $key => $comment)
            <li class="border rounded-md p-3 my-3 w-full" wire:key="comments_{{ $comment['comment_id'] }}_{{ time() }}">
                <div class="text-sm font-semibold w-full flex">
                    <div class="mt-2 mr-2">{{ $comment['user'] }} <span class="font-normal text-sm">{{ $comment['date'] }}</span></div>
                    @if ($comment['user_id'] == auth()->user()->id)
                        <x-delete-button
                            :key="$key"
                            :function="$deleteFunction"
                            class="mt-2"
                            wrapperClasses="ml-auto"
                        />
                    @endif
                </div>
                <div class="w-full">
                    {{ $comment['comment'] }}
                </div>
            </li>
        @endforeach
        <li class="my-3" wire:key="comments_add_new.{{ time() }}">
            <x-input-group
                type="textarea"
                placeholder=""
                id="newComment"
                name="newComment"
                required="required"
                wire:model.lazy="newComment"
                labelText="Add Comment"
                rows="3"
            />
            <button
                type="button"
                class="mt-2 focus:ring-red flex w-auto justify-center rounded-lg bg-gray-900 px-4 py-2 text-xs font-medium text-white transition duration-150 ease-in-out hover:bg-green-700 focus:border-green-700 focus:outline-none active:bg-green-700"
                wire:click="addComment"
            >
                Add Comment
            </button>
        </li>
    </ul>
</div>