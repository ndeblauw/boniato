<?php

use App\View\Components\FormSelect;
use Illuminate\View\View;

it('renders form select component', function () {
    $component = new FormSelect('category', 'Category', ['cat1' => 'Category 1', 'cat2' => 'Category 2'], 'cat1', 'Select category');
    
    $view = $component->render();
    
    expect($view)->toBeInstanceOf(View::class);
    expect($view->name())->toBe('components.form-select');
});

it('constructs with required parameters', function () {
    $options = ['opt1' => 'Option 1', 'opt2' => 'Option 2'];
    $component = new FormSelect('type', 'Type', $options);
    
    expect($component->name)->toBe('type');
    expect($component->label)->toBe('Type');
    expect($component->options)->toBe($options);
    expect($component->value)->toBeNull();
    expect($component->placeholder)->toBeNull();
});

it('constructs with all parameters', function () {
    $options = ['cat1' => 'Category 1', 'cat2' => 'Category 2'];
    $component = new FormSelect('category', 'Category', $options, 'cat1', 'Select a category');
    
    expect($component->name)->toBe('category');
    expect($component->label)->toBe('Category');
    expect($component->options)->toBe($options);
    expect($component->value)->toBe('cat1');
    expect($component->placeholder)->toBe('Select a category');
});

it('accepts numeric options array', function () {
    $options = ['Category 1', 'Category 2', 'Category 3'];
    $component = new FormSelect('category', 'Category', $options);
    
    expect($component->options)->toBe($options);
});

it('accepts associative options array', function () {
    $options = ['cat1' => 'First Category', 'cat2' => 'Second Category'];
    $component = new FormSelect('category', 'Category', $options);
    
    expect($component->options)->toBe($options);
});

it('accepts null value', function () {
    $options = ['opt1' => 'Option 1'];
    $component = new FormSelect('type', 'Type', $options, null);
    
    expect($component->value)->toBeNull();
});

it('accepts null placeholder', function () {
    $options = ['opt1' => 'Option 1'];
    $component = new FormSelect('type', 'Type', $options, 'opt1', null);
    
    expect($component->placeholder)->toBeNull();
});

it('accepts empty string placeholder', function () {
    $options = ['opt1' => 'Option 1'];
    $component = new FormSelect('type', 'Type', $options, 'opt1', '');
    
    expect($component->placeholder)->toBe('');
});

it('renders without errors', function () {
    $options = ['opt1' => 'Option 1'];
    $component = new FormSelect('type', 'Type', $options);
    
    expect(fn() => $component->render())->not->toThrow(Exception::class);
});