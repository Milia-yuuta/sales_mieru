<?php

namespace App\View\Components\Prospect\Label\Column;

use Illuminate\View\Component;


class Status extends Component
{
    public function __construct(public string $status)
    {
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.prospect.label.column.status');
    }
}