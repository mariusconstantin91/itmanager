<?php
namespace App\Http\Livewire\Skills;

use App\Models\Skill;
use Livewire\Component;

abstract class Action extends Component
{
    /**
     * The main entity of the component
     *
     * @var Skill
     */
    public Skill $skill;

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();
}
