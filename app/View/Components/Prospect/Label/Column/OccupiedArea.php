<?php

namespace App\View\Components\Prospect\Label\Column;

use Illuminate\View\Component;


class OccupiedArea extends Component
{
    public function __construct(public int $area)
    {
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.prospect.label.column.occupied-area');
    }
}