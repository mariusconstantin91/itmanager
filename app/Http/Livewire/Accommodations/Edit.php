<?php
namespace App\Http\Livewire\Accommodations;

class Edit extends Action
{

    /**
     * Function from livewire hooks
     * Set default data on properties
     *
     * @return void
     */
    public function mount()
    {
        parent::mount();
        $this->name = $this->accommodation->name;
        $this->type = $this->accommodation->type;
        $this->rating = $this->accommodation->rating;
        $this->checkin = $this->accommodation->checkin;
        $this->checkout = $this->accommodation->checkout;
        $this->childDiscount = $this->accommodation->discount_children;
        $this->infantDiscount = $this->accommodation->discount_infants;
        $this->margin = $this->accommodation->margin;
        $this->providerId = $this->accommodation->provider_id;
        $this->providerIdInput = $this->accommodation->provider->name;
        $this->categoryId = $this->accommodation->accommodation_category_id;
        $this->categoryIdInput = $this->accommodation->accommodationCategory->name;
        $this->currencyId = $this->accommodation->currency_id;
        $this->currencyIdInput = $this->accommodation->currency->name;
        $this->locationId = $this->accommodation->location_id;
        $this->locationIdInput = $this->accommodation->location->name;
        $this->languageIds = $this->accommodation->languages->pluck('id')->toArray();
        $this->tagIds = $this->accommodation->tags->pluck('id')->toArray();
    }

    /**
     * Save the details in the database
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();
        $this->accommodation->margin = 0;
        $this->accommodation->save();

        $this->accommodation->languages()->sync($this->languageIds);
        $this->accommodation->tags()->sync($this->tagIds);

        return redirect()->with(['message' => 'The accommodation was created!'])->route('accommodations.index');
    }

    /**
     * Return the used form
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.accommodations.form', [
            'title' => 'Edit Accommodation',
        ]);
    }
}
