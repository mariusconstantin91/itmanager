<div x-data="{ showSuccessAlert: 'true' }">
    <header class="mb-8 flex items-center">
        <h2 class="text-3xl font-semibold text-black-500">
            Rental Cars
        </h2>
        <a
            class="ml-4 flex items-center rounded-lg bg-gray-200 px-3 py-2 text-xs hover:bg-gray-300"
            href="{{ route('rentalcars.create') }}"
        >
            Add New <i class="fa-solid fa-plus ml-2"></i>
        </a>
    </header>
    <div class="main-content">
        <x-alerts.success />

        <x-datatable::layout :datatable-class="$datatable" />
    </div>
</div>
