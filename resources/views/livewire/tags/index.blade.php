<div>
    <div
        class="location-filters mb-4 text-3xl font-semibold text-black-500"
    >
        <header class="mb-8 flex items-center">
            <h2 class="text-3xl font-semibold text-black-500">
                Tags
            </h2>
            <a
                class="ml-4 flex items-center rounded-lg bg-gray-200 px-3 py-2 text-xs hover:bg-gray-300"
                href="{{ route('settings.tags.create') }}"
            >
                Add New <i class="fa-solid fa-plus ml-2"></i>
            </a>
        </header>
        <div class="mb-4 flex items-end">
            <livewire:datatable::search :datatable-class="$datatable" />
        </div>
    </div>
    <div class="main-content"  x-data="{
        showSuccessAlert: true
    }">
        <x-alerts.success />
        <x-datatable::layout :datatable-class="$datatable">

        </x-datatable::layout>
    </div>
</div>
