@props([
    'class' => '',
    'message' => session('message'),
])

<div
    class="w-full shrink-0"
    x-show="showSuccessAlert"
>
    @if (session()->has('message') || $message)
        <div
            class="{{ $class }} relative mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700 dark:bg-green-200 dark:text-green-800"
            role="alert"
        >
            <span class="text-sm font-medium"> {{ $message }} </span>
            <div
                class="absolute right-4 top-2 cursor-pointer align-middle text-xl font-semibold text-black-500"
                @click="showSuccessAlert = false;"
            >
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>
    @endif
</div>
