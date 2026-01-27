<?php

use App\View\Components\AppLayout;
use Illuminate\View\View;

it('renders app layout component', function () {
    $component = new AppLayout();
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.app-layout');
});

it('constructs without parameters', function () {
    $component = new AppLayout();
    
    expect($component)->toBeInstanceOf(AppLayout::class);
});

it('renders without errors', function () {
    $component = new AppLayout();
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});