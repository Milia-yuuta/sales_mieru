<?php

namespace App\View\Components;

use App\Models\UserMaster;
use Illuminate\View\Component;

class officeSelect extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $selected;
    public $offices;
    public function __construct(UserMaster $userMaster, $selected)
    {
        $this->selected = $selected;
        $this->offices = $userMaster->OfficeList;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.office-select',[
            'offices' => $this->offices,
        ]);
    }
}
