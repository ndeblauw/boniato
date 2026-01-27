<?php

use App\View\Components\SiteLayoutHeader;
use Illuminate\View\View;

it('renders site layout header component', function () {
    $component = new SiteLayoutHeader();
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.site-layout-header');
});

it('constructs without parameters', function () {
    $component = new SiteLayoutHeader();
    
    expect($component)->toBeInstanceOf(SiteLayoutHeader::class);
});

it('renders without errors', function () {
    $component = new SiteLayoutHeader();
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});