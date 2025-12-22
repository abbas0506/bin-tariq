<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class message extends Component
{
    /**
     * Create a new component instance.
     */
    public $errors;
    public function __construct($errors = null)
    {
        //
        $this->errors = $errors;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message');
    }
}
