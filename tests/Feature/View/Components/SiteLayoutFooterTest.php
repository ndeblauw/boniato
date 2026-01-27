<?php

use App\View\Components\SiteLayoutFooter;
use Illuminate\View\View;

it('renders site layout footer component', function () {
    $component = new SiteLayoutFooter();
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.site-layout-footer');
});

it('constructs without parameters', function () {
    $component = new SiteLayoutFooter();
    
    expect($component)->toBeInstanceOf(SiteLayoutFooter::class);
});

it('renders without errors', function () {
    $component = new SiteLayoutFooter();
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});