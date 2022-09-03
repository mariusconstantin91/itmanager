<?php
namespace App\Http\Livewire\RentalCars;

use App\Models\RentalCar;
use Livewire\Component;

class Edit extends Action
{
    /**
     * Livewire equivalent of contruct method.
     *
     * @return void
     */
    public function mount()
    {
        foreach ($this->rentalCar->rentalCarReturnFees as $returnFeeItem) {
            $this->returnFeeItems[] = [
                'fee' => $returnFeeItem->fee,
                'pick_up_location_id' => $returnFeeItem->pick_up_location_id,
                'drop_off_location_id' => $returnFeeItem->drop_off_location_id,
            ];
        }
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

        $this->rentalCar->rentalCarReturnFees()->delete();

        foreach ($this->returnFeeItems as $returnFeeItem) {
            $rentalCarReturnFee = $this->rentalCar->rentalCarReturnFees()->make([
                'fee' => $returnFeeItem['fee'],
            ]);

            $rentalCarReturnFee->pick_up_location_id = $returnFeeItem['pick_up_location_id'];
            $rentalCarReturnFee->drop_off_location_id = $returnFeeItem['drop_off_location_id'];

            $rentalCarReturnFee->save();
        }

        return redirect()->with(['message' => 'The rental car was updated.']);
    }

    /**
     * Return the used form.
     *
     * @return \Illuminate\View
     */
    public function render()
    {
        return view('livewire.rentalcars.form', [
            'title' => 'Edit Rental Car',
        ]);
    }
}
