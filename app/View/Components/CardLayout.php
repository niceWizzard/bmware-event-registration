<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class CardLayout extends BaseLayout
{

    public string $cardTitle;
    public string $cardTitleClass;

    public function __construct(string $cardTitle = 'Card Title', string $cardTitleClass = '', string $title = 'Default Title', bool $overrideTitle = false)
    {
        parent::__construct($title, $overrideTitle);
        $this->cardTitle = $cardTitle;
        $this->cardTitleClass = $cardTitleClass;
    }

    public function render(): View|Closure|string
    {
        return view('layouts.card-layout');
    }
}
