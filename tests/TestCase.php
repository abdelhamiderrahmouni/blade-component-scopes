<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use BladeComponentScopes\Laravel\BladeComponentScopesServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithViews;

    protected function getPackageProviders($app): array
    {
        return [
            BladeComponentScopesServiceProvider::class,
        ];
    }
}
