<?php
namespace App\Http\Livewire\RentalCars;

use App\Models\RentalCar;
use Livewire\Component;

class Add extends Action
{
    /**
     * Livewire equivalent of contruct method.
     *
     * @return void
     */
    public function mount()
    {
        $this->rentalCar = new RentalCar();
        $this->rentalCar->active = true;
    }
    
    /**
     * Persist models and their properties to database.
     *
     * @return \Illuminate\Support\Facades\Redirect
     */
    public function save()
    {
        $this->validate();

        $this->rentalCar->save();
        
        foreach ($this->returnFeeItems as $returnFeeItem) {
            $rentalCarReturnFee = $this->rentalCar->rentalCarReturnFees()->make([
                'fee' => $returnFeeItem['fee'],
            ]);

            $rentalCarReturnFee->pick_up_location_id = $returnFeeItem['pick_up_location_id'];
            $rentalCarReturnFee->drop_off_location_id = $returnFeeItem['drop_off_location_id'];

            $rentalCarReturnFee->save();
        }

        return redirect()->with(['message' => 'A new rental car was added!'])->route('rentalcars.index');
    }

    /**
     * Return the used form.
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.rentalcars.form', [
            'title' => 'Add Rental Car',
        ]);
    }
}
