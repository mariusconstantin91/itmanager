@props([
    'class' => '',
    'message' => 'Error Delete'
])

<div
    class="w-full shrink-0"
    x-show="showErrorAlert"
>
    @if (session()->has('messageError'))
        <div
            class="relative mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700 dark:bg-red-200 dark:text-red-800"
            role="alert"
        >
            <span class="text-sm font-medium"> {{ session('messageError') }}
            </span>
        </div>
    @endif
</div>
