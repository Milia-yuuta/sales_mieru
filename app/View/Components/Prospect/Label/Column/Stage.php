<?php

namespace App\View\Components\Prospect\Label\Column;

use Illuminate\View\Component;


class Stage extends Component
{
    public function __construct(public string $actionName)
    {
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.prospect.label.column.stage');
    }


    public function dataOption()
    {
        return match ($this->actionName) {
            '判別' => 'discrimination',
            '潜在' => 'latent',
            '顕在' => 'overt',
            '媒介' => 'mediation',
            default => null
        };
    }
}