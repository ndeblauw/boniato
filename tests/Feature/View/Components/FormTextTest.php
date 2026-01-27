<?php

use App\View\Components\FormText;
use Illuminate\View\View;

it('renders form text component', function () {
    $component = new FormText('email', 'Email Address', 'Enter your email');
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.form-text');
});

it('constructs with required parameters', function () {
    $component = new FormText('username', 'Username');
    
    expect($component->name)->toBe('username');
    expect($component->label)->toBe('Username');
    expect($component->placeholder)->toBe('');
    expect($component->value)->toBe('');
});

it('constructs with all parameters', function () {
    $component = new FormText('email', 'Email Address', 'Enter email', 'test@example.com');
    
    expect($component->name)->toBe('email');
    expect($component->label)->toBe('Email Address');
    expect($component->placeholder)->toBe('Enter email');
    expect($component->value)->toBe('test@example.com');
});

it('accepts empty placeholder', function () {
    $component = new FormText('name', 'Name', '');
    
    expect($component->placeholder)->toBe('');
});

it('accepts empty value', function () {
    $component = new FormText('name', 'Name', 'Enter name', '');
    
    expect($component->value)->toBe('');
});

it('renders without errors', function () {
    $component = new FormText('test', 'Test Label', 'Test Placeholder', 'Test Value');
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});