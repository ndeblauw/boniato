<?php

use App\View\Components\SiteLayout;
use Illuminate\View\View;

it('renders site layout component', function () {
    $component = new SiteLayout();
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.site-layout');
});

it('constructs with default null title', function () {
    $component = new SiteLayout();
    
    expect($component->title)->toBeNull();
});

it('constructs with custom title', function () {
    $component = new SiteLayout('Custom Page Title');
    
    expect($component->title)->toBe('Custom Page Title');
});

it('accepts empty string title', function () {
    $component = new SiteLayout('');
    
    expect($component->title)->toBe('');
});

it('renders view without errors', function () {
    $component = new SiteLayout('Test Title');
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});