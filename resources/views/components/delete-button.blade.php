@props(['key', 'class' => '', 'title' => 'Delete item', 'message' => 'Are you sure?', 'function' => 'deleteLine', 'wrapperClasses' => ''])
<div x-data="{ showConfirmationModal: false }" class="{{ $wrapperClasses }}">
    <button
        type="button"
        @click="showConfirmationModal = true"
        class="focus:ring-red {{ $class }} flex w-auto justify-center rounded-lg bg-gray-900 px-4 py-2 text-xs font-medium text-white transition duration-150 ease-in-out hover:bg-red-700 focus:border-red-700 focus:outline-none active:bg-red-700"
    >
        Delete
    </button>

    <x-modals.confirm
        :id="$key"
        function="{{ $function }}"
        title="{{ $title }}"
        xshow="showConfirmationModal"
    >{{ $message }}</x-modals.confirm>
</div>
