 <div x-data="{ showSuccessAlert: 'true' }">
     <form
         wire:submit.prevent="save"
         id="actions-form"
     >
         @csrf
         <div class="align-start mb-4 flex">
             <div class="text-3xl font-semibold text-black-500">
                 {{ $title }}
             </div>
             <div class="ml-auto w-auto">
                 <a
                     class="mr-4 rounded-lg border border-black-500 bg-transparent py-2 px-5 pb-2.5 text-sm font-medium text-black-500 hover:bg-gray-200"
                     href="{{ route('contacts.create') }}"
                 >Cancel</a>
                 <button
                     class="rounded-lg bg-gray-900 py-2 px-5 pb-2.5 text-sm font-medium text-white hover:bg-green-700"
                     wire:loading.attr="disabled"
                     @click="showSuccessAlert = true;"
                     type="submit"
                 >Save</button>
             </div>
         </div>
         <div class="main-content mb-16">
             <div class="flex flex-wrap">
                 <x-alerts.success />
                 <div class="w-full">
                     <x-panel
                         label="Details"
                         wrapperExtraClasses=""
                     >
                         <div class="flex">
                             <div class="w-1/2 pr-3">
                                 <x-input-group
                                     type="text"
                                     id="name"
                                     name="accommodation.name"
                                     wire:model.lazy="accommodation.name"
                                     labelText="Name"
                                 > </x-input-group>
                                 <x-input-group
                                     type="select-formated"
                                     id="type"
                                     name="accommodation.type"
                                     wire:model.lazy="accommodation.type"
                                     labelText="Type"
                                     :options="$typeOptions"
                                     optionsProperty="typeOptions"
                                     selected="Select"
                                     wrapperClass="mt-8"
                                 > </x-input-group>
                                 <x-input-group
                                     type="select-formated"
                                     id="rating"
                                     name="accommodation.rating"
                                     wire:model.lazy="accommodation.rating"
                                     labelText="Rating"
                                     :options="$this->ratingOptions"
                                     optionsProperty="ratingOptions"
                                     wrapperClass="mt-8"
                                 > </x-input-group>
                                 <x-input-group
                                     type="search-dropdown-extended"
                                     :initialText="optional(
                                         $this->accommodation->location,
                                     )->name"
                                     placeholder="Start typing"
                                     id="locationId"
                                     name="accommodation.location_id"
                                     wire:model.lazy="accommodation.location_id"
                                     labelText="Location"
                                     wrapperClass="mt-8"
                                     functionOptions="locationUpdated"
                                 > </x-input-group>
                                 <x-input-group
                                     type="search-dropdown-extended"
                                     :initialText="optional(
                                         $this->accommodation->provider,
                                     )->name"
                                     placeholder="Start typing"
                                     id="accommodation.provider_id"
                                     name="accommodation.provider_id"
                                     wire:model.lazy="accommodation.provider_id"
                                     labelText="Provider"
                                     wrapperClass="mt-8"
                                     functionOptions="providerUpdated"
                                 > </x-input-group>
                                 <x-input-group
                                     type="time"
                                     id="checkin"
                                     name="accommodation.checkin"
                                     wire:model.lazy="accommodation.checkin"
                                     labelText="Check-in"
                                     wrapperClass="mt-8"
                                 > </x-input-group>
                                 <x-input-group
                                     type="time"
                                     id="checkout"
                                     name="accommodation.checkout"
                                     wire:model.lazy="accommodation.checkout"
                                     labelText="Check-out"
                                     wrapperClass="mt-8"
                                 > </x-input-group>

                             </div>
                             <div class="w-1/2 pl-3">
                                 <x-input-group
                                     type="select-formated"
                                     id="category"
                                     :initialText="optional(
                                         $this->accommodation
                                             ->accommodationCategory,
                                     )->name"
                                     name="accommodation.accommodation_category_id"
                                     wire:model="accommodation.accommodation_category_id"
                                     labelText="Category"
                                     :options="$this->categoryOptions"
                                     optionsProperty="categoryOptions"
                                 > </x-input-group>

                                 <x-input-group
                                     type="search-dropdown-extended"
                                     :initialText="optional(
                                         $this->accommodation->currency,
                                     )->name"
                                     placeholder="Start Typing"
                                     id="accommodation.currency_id"
                                     name="accommodation.currency_id"
                                     wire:model.lazy="accommodation.currency_id"
                                     labelText="Currency"
                                     wrapperClass="mt-8"
                                     functionOptions="currencyUpdated"
                                 > </x-input-group>

                                 <x-input-group
                                     type="number-buttons"
                                     id="accommodation.discount_children"
                                     name="accommodation.discount_children"
                                     wire:model.lazy="accommodation.discount_children"
                                     labelText="Child Discount"
                                     wrapperClass="mt-8"
                                 > </x-input-group>
                                 <x-input-group
                                     type="number-buttons"
                                     id="accommodation.discount_infants"
                                     name="accommodation.discount_infants"
                                     wire:model.lazy="accommodation.discount_infants"
                                     labelText="Infant Discount"
                                     wrapperClass="mt-8"
                                 > </x-input-group>

                                 <x-input-group
                                     type="select-formated-multi"
                                     id="language"
                                     input="languageInput"
                                     name="languageIds"
                                     wire:model="languageIds"
                                     labelText="Languages"
                                     :options="$languageOptions"
                                     optionsProperty="languageOptions"
                                     wrapperClass="mt-8"
                                 > </x-input-group>

                                 <x-input-group
                                     type="select-formated-multi"
                                     id="tag"
                                     input="tagInput"
                                     name="tagIds"
                                     wire:model="tagIds"
                                     labelText="Tags"
                                     :options="$tagOptions"
                                     optionsProperty="tagOptions"
                                     wrapperClass="mt-8"
                                 > </x-input-group>
                             </div>
                         </div>
                     </x-panel>
                     <x-panel
                         label="Contact Details"
                         wrapperExtraClasses="mt-5"
                     >

                     </x-panel>
                 </div>
             </div>
         </div>
     </form>
 </div>
