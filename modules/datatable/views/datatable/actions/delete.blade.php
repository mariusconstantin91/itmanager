<div
    x-data="{ deleteDataTableRecordModal: false }"
    x-on:show-delete-datatable-record-modal-{{ $entity->{$primaryKey} }}.window="deleteDataTableRecordModal = true"
>
    <a
        href="#"
        wire:click.prevent="deleteAction({{ $entity->{$primaryKey} }})"
        {{ $action->renderAttributes() }}
        class="text-red-700"
    >
        {{ $action->text }}
    </a>

    @if ($action->requireConfirmation)
        <x-modals.modal
            :size="'sm'"
            :xshow="'deleteDataTableRecordModal'"
            :title="'Delete #' . $entity->{$primaryKey}"
            :actions="[
                [
                    'close_modal_onclick' => true,
                    'text' => 'Yes',
                    'button_classes' => 'text-white mr-4 rounded-lg border border-black-500 bg-gray-900 py-2 px-5 pb-2.5 text-sm font-medium hover:bg-green-700 hover:border-green-700',
                    'attributes' => [
                        'wire:click' => 'deleteAction(' . $entity->{$primaryKey} . ', true)'
                    ]
                ]
            ]"
        >
            Are you sure you want to delete record #{{ $entity->{$primaryKey} }}?
        </x-modals.modal>
    @endif
</div>
