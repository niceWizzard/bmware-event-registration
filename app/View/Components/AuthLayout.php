<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class AuthLayout extends BaseLayout
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.auth-layout');
    }
}
