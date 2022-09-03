<div>
    <div
        class="location-filters mb-4 text-3xl font-semibold text-black-500"
        x-data="{ showFilters: false }"
    >
        <header class="mb-8 flex items-center">
            <h2 class="text-3xl font-semibold text-black-500">
                Comments
            </h2>
            <a
                class="ml-4 flex items-center rounded-lg bg-gray-200 px-3 py-2 text-xs hover:bg-gray-300"
                href="{{ route('comments.create') }}"
            >
                Add New <i class="fa-solid fa-plus ml-2"></i>
            </a>
        </header>
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
            <livewire:datatable::search :datatable-class="$datatable" />
        </div>

        <div x-show="showFilters">
            <livewire:datatable::filters
                :datatable-class="$datatable"
                :title="'Filters'"
            />
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
