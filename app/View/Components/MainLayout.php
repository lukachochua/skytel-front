<?php

namespace App\View\Components;

use App\Models\Link;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MainLayout extends Component
{
    public $navbarLinks;
    public $footerLinks;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->navbarLinks = Link::where('type', 'navbar')->get();
        $this->footerLinks = Link::where('type', 'footer')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.main');
    }
}
