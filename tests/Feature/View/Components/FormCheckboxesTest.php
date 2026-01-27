<?php

use App\View\Components\FormCheckboxes;
use Illuminate\View\View;

it('renders form checkboxes component', function () {
    $component = new FormCheckboxes('categories', 'Categories', [
        'cat1' => 'Category 1',
        'cat2' => 'Category 2'
    ], ['cat1']);
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.form-checkboxes');
});

it('constructs with required parameters', function () {
    $options = ['opt1' => 'Option 1', 'opt2' => 'Option 2'];
    $component = new FormCheckboxes('features', 'Features', $options);
    
    expect($component->name)->toBe('features');
    expect($component->label)->toBe('Features');
    expect($component->options)->toBe($options);
    expect($component->values)->toBe([]);
});

it('constructs with all parameters', function () {
    $options = ['cat1' => 'Category 1', 'cat2' => 'Category 2'];
    $component = new FormCheckboxes('categories', 'Categories', $options, ['cat1', 'cat2']);
    
    expect($component->name)->toBe('categories');
    expect($component->label)->toBe('Categories');
    expect($component->options)->toBe($options);
    expect($component->values)->toBe(['cat1', 'cat2']);
});

it('accepts empty values array', function () {
    $options = ['opt1' => 'Option 1'];
    $component = new FormCheckboxes('feature', 'Feature', $options, []);
    
    expect($component->values)->toBe([]);
});

it('accepts null values', function () {
    $options = ['opt1' => 'Option 1'];
    $component = new FormCheckboxes('feature', 'Feature', $options, null);
    
    expect($component->values)->toBe([]);
});

it('accepts single selected value', function () {
    $options = ['opt1' => 'Option 1', 'opt2' => 'Option 2'];
    $component = new FormCheckboxes('choice', 'Choice', $options, ['opt1']);
    
    expect($component->values)->toBe(['opt1']);
});

it('accepts multiple selected values', function () {
    $options = ['opt1' => 'Option 1', 'opt2' => 'Option 2', 'opt3' => 'Option 3'];
    $component = new FormCheckboxes('choices', 'Choices', $options, ['opt1', 'opt3']);
    
    expect($component->values)->toBe(['opt1', 'opt3']);
});

it('accepts numeric options array', function () {
    $options = ['Option 1', 'Option 2', 'Option 3'];
    $component = new FormCheckboxes('options', 'Options', $options, [0, 2]);
    
    expect($component->options)->toBe($options);
    expect($component->values)->toBe([0, 2]);
});

it('renders without errors', function () {
    $options = ['opt1' => 'Option 1'];
    $component = new FormCheckboxes('option', 'Option', $options);
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});