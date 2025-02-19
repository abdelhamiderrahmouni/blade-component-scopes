<?php

declare(strict_types=1);

use Illuminate\View\ComponentAttributeBag;

it('can scope attributes with a specific prefix', function () {
    $attributes = new ComponentAttributeBag([
        'label:class' => 'font-bold',
        'label:for' => 'test-input',
        'input:id' => 'test-input',
        'input:class' => 'border',
        'normal-attr' => 'value',
    ]);

    $labelAttributes = $attributes->scope('label');
    $inputAttributes = $attributes->scope('input');

    expect($labelAttributes->get('class'))->toBe('font-bold')
        ->and($labelAttributes->get('for'))->toBe('test-input')
        ->and($labelAttributes->has('input:id'))->toBeFalse()
        ->and($inputAttributes->get('id'))->toBe('test-input')
        ->and($inputAttributes->get('class'))->toBe('border');
});

it('can merge scoped attributes with defaults', function () {
    $attributes = new ComponentAttributeBag([
        'container:class' => 'mt-4',
        'container:id' => 'test-container',
    ]);

    $merged = $attributes->scope('container')->merge([
        'class' => 'flex gap-y-2',
        'data-testid' => 'container',
    ]);

    expect($merged['class'])->toBe('flex gap-y-2 mt-4')
        ->and($merged['id'])->toBe('test-container')
        ->and($merged['data-testid'])->toBe('container');
});

it('handles empty scoped attributes correctly', function () {
    $attributes = new ComponentAttributeBag([
        'normal-attr' => 'value',
    ]);

    $scopedAttributes = $attributes->scope('label');

    expect($scopedAttributes->getAttributes())->toBeEmpty();
});

it('preserves attribute types when scoping', function () {
    $attributes = new ComponentAttributeBag([
        'input:required' => true,
        'input:max' => 100,
        'input:data' => ['foo' => 'bar'],
    ]);

    $inputAttributes = $attributes->scope('input');

    expect($inputAttributes->get('required'))->toBeTrue()
        ->and($inputAttributes->get('max'))->toBe(100)
        ->and($inputAttributes->get('data'))->toBe(['foo' => 'bar']);
});

it('can handle multiple scopes on the same attributes bag', function () {
    $attributes = new ComponentAttributeBag([
        'label:class' => 'font-bold',
        'input:class' => 'border',
        'container:class' => 'mt-4',
    ]);

    $labelClass = $attributes->scope('label')->get('class');
    $inputClass = $attributes->scope('input')->get('class');
    $containerClass = $attributes->scope('container')->get('class');

    expect($labelClass)->toBe('font-bold')
        ->and($inputClass)->toBe('border')
        ->and($containerClass)->toBe('mt-4');
});

it('correctly merges class attributes with defaults', function () {
    $attributes = new ComponentAttributeBag([
        'input:class' => 'border-red-500 px-4',
    ]);

    $merged = $attributes->scope('input')->merge([
        'class' => 'border rounded py-2',
    ]);

    expect($merged['class'])->toBe('border rounded py-2 border-red-500 px-4');
});

it('handles boolean attributes correctly when scoping', function () {
    $attributes = new ComponentAttributeBag([
        'input:disabled' => true,
        'input:required' => false,
    ]);

    $inputAttributes = $attributes->scope('input');

    expect($inputAttributes->get('disabled'))->toBeTrue()
        ->and($inputAttributes->get('required'))->toBeFalse();
});

it('maintains original attributes when scoping', function () {
    $attributes = new ComponentAttributeBag([
        'id' => 'main',
        'input:class' => 'border',
    ]);

    $inputAttributes = $attributes->scope('input');

    expect($attributes->get('id'))->toBe('main')
        ->and($inputAttributes->get('class'))->toBe('border')
        ->and($attributes->get('input:class'))->toBe('border');
});
