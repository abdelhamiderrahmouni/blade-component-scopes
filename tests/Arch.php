<?php

declare(strict_types=1);

test('service providers')
    ->expect('BladeComponentScopes\Laravel\BladeComponentScopesServiceProvider')
    ->toOnlyUse([
        'Illuminate\Contracts\Support\DeferrableProvider',
        'Illuminate\Support\ServiceProvider',
        'Illuminate\View\Compilers\BladeCompiler',
        'Illuminate\View\ComponentAttributeBag',
    ]);
