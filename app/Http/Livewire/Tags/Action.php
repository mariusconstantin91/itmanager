<?php
namespace App\Http\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;

abstract class Action extends Component
{
    /**
     * The main entity of the component
     *
     * @var Tag
     */
    public Tag $tag;

    /**
     * Render function, should be implemented in child class
     *
     * @return void
     */
    abstract public function render();
}
