<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


/**
 * Breadcrumb component for navigation display.
 *
 * @property array<int, array{link: string, text: string}> $breadcrumbs
 */
class Breadcrumb extends Component
{

    /**
     * @param array<int, array{link: string, text: string}> $breadcrumbs
     */
    public function __construct(public readonly array $breadcrumbs)
    {
        //
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
