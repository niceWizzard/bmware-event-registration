<?php

namespace App\View\Components;

use App\Models\Event;
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
     * @param  array<int, array{link: string, text: string}>  $breadcrumbs
     */
    public function __construct(public readonly array $breadcrumbs)
    {
        //
    }

    public static function createEvent(Event $event, array $breadcrumbs): array
    {
        return self::createEventIndex([
            [
                'text' => $event->short_name,
                'link' => route('events.show', $event->short_name),
            ],
            ...$breadcrumbs,
        ]);
    }

    public static function createEventIndex(array $breadcrumbs): array
    {
        return [
            [
                'link' => route('events.index'),
                'text' => 'Events',
            ],
            ...$breadcrumbs,
        ];
    }

    public static function createAdminIndex(array $breadcrumbs): array
    {
        return [
            [
                'text' => 'Admin',
                'link' => route('admin.index'),
            ],
            ...$breadcrumbs,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
