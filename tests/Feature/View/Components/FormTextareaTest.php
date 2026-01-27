<?php

use App\View\Components\FormTextarea;
use Illuminate\View\View;

it('renders form textarea component', function () {
    $component = new FormTextarea('content', 'Content', 5, 'Enter content', 'Default content');
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.form-textarea');
});

it('constructs with required parameters', function () {
    $component = new FormTextarea('message', 'Message');
    
    expect($component->name)->toBe('message');
    expect($component->label)->toBe('Message');
    expect($component->rows)->toBe(3);
    expect($component->placeholder)->toBe('');
    expect($component->value)->toBe('');
    expect($component->rte)->toBeFalse();
});

it('constructs with all parameters', function () {
    $component = new FormTextarea(
        'description',
        'Description',
        6,
        'Enter description',
        'Default text',
        true
    );
    
    expect($component->name)->toBe('description');
    expect($component->label)->toBe('Description');
    expect($component->rows)->toBe(6);
    expect($component->placeholder)->toBe('Enter description');
    expect($component->value)->toBe('Default text');
    expect($component->rte)->toBeTrue();
});

it('accepts custom row count', function () {
    $component = new FormTextarea('content', 'Content', 10);
    
    expect($component->rows)->toBe(10);
});

it('accepts rich text editor flag', function () {
    $component = new FormTextarea('content', 'Content', 3, '', '', true);
    
    expect($component->rte)->toBeTrue();
});

it('accepts empty values', function () {
    $component = new FormTextarea('test', 'Test Label', 0, '', '');
    
    expect($component->rows)->toBe(0);
    expect($component->placeholder)->toBe('');
    expect($component->value)->toBe('');
});

it('renders without errors', function () {
    $component = new FormTextarea('content', 'Content');
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});