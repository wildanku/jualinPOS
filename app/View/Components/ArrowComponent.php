<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ArrowComponent extends Component
{
    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $url = $this->url;
        return view('components.arrow-component',compact('url'));
    }
}
