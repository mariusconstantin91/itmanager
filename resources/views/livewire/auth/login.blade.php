@section('title', 'Sign in to your account')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="/">
            <h1 class="text-center text-5xl text-gray-800">
                <b>It Manager</b>
            </h1>
        </a>
    </div>

    <div class="mt-16 max-w-md sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white px-4 pt-4 pb-8 shadow-xl sm:rounded-lg sm:px-10">
            <div class="mb-6">
                <h2
                    class="mt-6 text-center text-3xl font-medium leading-9 text-gray-900">
                    Sign in to your account
                </h2>
            </div>
            <form wire:submit.prevent="authenticate">
                <x-input-group
                    type='email'
                    placeholder=''
                    id="email"
                    name="email"
                    required='required'
                    wire:model.lazy="email"
                    labelText="Email"
                > </x-input-group>

                <x-input-group
                    type='password'
                    placeholder=''
                    id="password"
                    name="password"
                    required='required'
                    wire:model.lazy="password"
                    labelText="Password"
                    wrapperClass="mt-4"
                > </x-input-group>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            wire:model.lazy="remember"
                            id="remember"
                            type="checkbox"
                            class="form-checkbox h-4 w-4 text-green-600 transition duration-150 ease-in-out"
                        />
                        <label
                            for="remember"
                            class="ml-2 block text-sm leading-5 text-gray-900"
                        >
                            Remember
                        </label>
                    </div>

                    <div class="text-sm leading-5">
                        <a
                            href="{{ route('password.request') }}"
                            class="font-medium text-green-900 transition duration-150 ease-in-out hover:text-green-700 focus:underline focus:outline-none"
                        >
                            Forgot your password?
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button
                            type="submit"
                            class="focus:ring-green flex w-full justify-center rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out hover:bg-gray-900 focus:border-gray-900 focus:outline-none active:bg-gray-900"
                        >
                            Sign in
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
