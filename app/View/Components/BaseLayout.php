<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseLayout extends Component
{
    public string $title;
    public bool $overrideTitle;

    public function __construct(string $title = 'Default Title', bool $overrideTitle = false)
    {
        $this->title = $title;
        $this->overrideTitle = $overrideTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.base-layout');
    }
}
