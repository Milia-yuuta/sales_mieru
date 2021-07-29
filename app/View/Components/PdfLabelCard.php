<?php

namespace App\View\Components;

use Illuminate\View\Component;


class PdfLabelCard extends Component
{
    public const WIDTH = 74.25;
    public const HEIGHT = 42;

    public int $horizontalOffset;
    public int $verticalOffset;


    public function __construct(public string $zipcode,
                                public string $address,
                                public string $buildingName,
                                public string $roomNumber,
                                public string $clientName,
                                public string $code,
                                public int $rowOffset = 0,
                                int $columnOffset = 0
    )
    {
        $this->horizontalOffset = self::WIDTH * $columnOffset;
        $this->verticalOffset = self::HEIGHT * $rowOffset;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.pdf-label-card');
    }


    public function position(int $topBaseOffset, int $leftBaseOffset)
    {
        $top = $topBaseOffset + $this->verticalOffset;
        $left = $leftBaseOffset + $this->horizontalOffset;

        return "style=\"position: absolute; top: {$top}mm; left: {$left}mm\"";
    }
}