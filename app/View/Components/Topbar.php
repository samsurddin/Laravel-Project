<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Topbar extends Component
{
    public $email, $phone, $company;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $email="sales@eit.com.bd", 
        $phone="+88 01711 165 947", 
        $company="Eastern Information Technologies Limited"
    )
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->company = $company;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.topbar');
    }
}
