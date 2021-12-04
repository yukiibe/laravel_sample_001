<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppBar extends Component
{
    /**
     * The title for the navigation drawer
     * 
     * @var String
     */
    public $title;

     /**
     * Create a new component instance.
     *
     * @param String  $title
     * @return void
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.app-bar');
    }
}
