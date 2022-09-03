<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="/">
            <h1 class="text-center text-5xl text-gray-800"><b>Cuba Buddy </b>
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
            <form wire:submit.prevent="resetPassword">
                <input
                    wire:model="token"
                    type="hidden"
                >

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

                <x-input-group
                    type='password'
                    placeholder=''
                    id="password_confirmation"
                    name="password_confirmation"
                    required='required'
                    wire:model.lazy="passwordConfirmation"
                    labelText="Comfirm Password"
                    wrapperClass="mt-4"
                >
                </x-input-group>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button
                            type="submit"
                            class="focus:ring-green flex w-full justify-center rounded-lg bg-green-700 px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out hover:bg-gray-900 focus:border-gray-900 focus:outline-none active:bg-gray-900"
                        >
                            Reset password
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
