<?php

declare(strict_types=1);

namespace BladeComponentScopes\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\View\ComponentAttributeBag;

class BladeComponentScopesServiceProvider extends BaseServiceProvider
{
    public function register(): void
    {
        ComponentAttributeBag::macro('scope', function (string $scope): ComponentAttributeBag {
            $prefix = $scope . ':';
            $prefixLength = strlen($prefix);

            $scopedAttributes = [];
            foreach ($this->getAttributes() as $key => $value) {
                if (str_starts_with($key, $prefix)) {
                    $scopedAttributes[substr($key, $prefixLength)] = $value;
                }
            }

            return new ComponentAttributeBag($scopedAttributes);
        });
    }

    public function boot(): void
    {
        //
    }
}
