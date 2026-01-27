<?php

use App\View\Components\GuestLayout;
use Illuminate\View\View;

it('renders guest layout component', function () {
    $component = new GuestLayout();
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.guest-layout');
});

it('constructs without parameters', function () {
    $component = new GuestLayout();
    
    expect($component)->toBeInstanceOf(GuestLayout::class);
});

it('renders without errors', function () {
    $component = new GuestLayout();
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});