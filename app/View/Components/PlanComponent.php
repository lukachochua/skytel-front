<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Plan;
use App\Models\PlanType;
use App\Models\TvPlan;

class PlanComponent extends Component
{
    public $plan;
    public $tvPlan;

    /**
     * Create a new component instance.
     *
     * @param  Plan  $plan
     * @param  TvPlan|null  $tvPlan
     * @return void
     */
    public function __construct(Plan $plan, TvPlan $tvPlan = null)
    {
        $this->plan = $plan;
        $this->tvPlan = $tvPlan;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.plan-component');
    }
}
