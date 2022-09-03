@section('title', 'Reset password')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="/">
            <h1 class="text-center text-5xl text-gray-800"><b>It Manager </b>
                <h1 />
        </a>
    </div>

    <div class="mt-16 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-gray-50 px-4 pb-8 pt-4 shadow-xl sm:rounded-lg sm:px-10">
            <div class="mb-6">
                <h2
                    class="mt-6 text-center text-3xl font-medium leading-9 text-gray-900">
                    Reset password
                </h2>
            </div>
            @if ($emailSentMessage)
                <div class="rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <p
                                class="text-sm font-medium leading-5 text-green-800">
                                {{ $emailSentMessage }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <form wire:submit.prevent="sendResetPasswordLink">
                    <x-input-group
                        type='email'
                        placeholder=''
                        id="email"
                        name="email"
                        required='required'
                        wire:model.lazy="email"
                        labelText="Email"
                    >
                    </x-input-group>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <button
                                type="submit"
                                class="focus:ring-green flex w-full justify-center rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out hover:bg-gray-900 focus:border-gray-900 focus:outline-none active:bg-gray-900"
                            >
                                Send password reset link
                            </button>
                        </span>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
