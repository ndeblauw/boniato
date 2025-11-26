<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SessionInfo extends Component
{
    public array $history;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->history = session()->get('history', []);
        $this->history[] = url()->current();
        session()->put('history', $this->history);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.session-info');
    }
}
