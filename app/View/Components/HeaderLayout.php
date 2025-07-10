<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class HeaderLayout extends BaseLayout
{
    public string $headerTitle;

    public function __construct(string $headerTitle = "Event Registration", string $title = 'Default Title', bool $overrideTitle = false)
    {
        parent::__construct($title, $overrideTitle);
        $this->headerTitle = $headerTitle;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.header-layout');
    }
}
