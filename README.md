<p align="center">
    <img src="https://raw.githubusercontent.com/abdelhamiderrahmouni/blade-component-scopes/main/art/example.png" width="600" alt="Scopes for Laravel Blade Components">
    <p align="center">
        <a href="https://github.com/abdelhamiderrahmouni/blade-component-scopes/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/abdelhamiderrahmouni/blade-component-scopes/tests.yml?branch=main&label=tests&style=round-square"></a>
        <a href="https://packagist.org/packages/abdelhamiderrahmouni/blade-component-scopes"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/abdelhamiderrahmouni/blade-component-scopes"></a>
        <a href="https://packagist.org/packages/abdelhamiderrahmouni/blade-component-scopes"><img alt="Latest Version" src="https://img.shields.io/packagist/v/abdelhamiderrahmouni/blade-component-scopes"></a>
        <a href="https://packagist.org/packages/abdelhamiderrahmouni/blade-component-scopes"><img alt="License" src="https://img.shields.io/github/license/abdelhamiderrahmouni/blade-component-scopes"></a>
    </p>
</p>

------

# Scopes for Laravel Blade Components 
This package allows you to scope attributes to specific elements within your Blade components.

```php
<label {{ $attributes->scope('label')->merge(['class' => 'text-gray-500']) }}>
```

## Installation
> **Requires [php 8.2+](https://www.php.net/downloads.php) and [Laravel 10+](https://github.com/laravel/laravel)**

First, install `Scopes for Laravel Blade Components` via [composer](https://getcomposer.org/):

```bash
composer require abdelhamiderrahmouni/blade-component-scopes
```
## Usage
This package adds a `scope()` macro to Laravel's ComponentAttributeBag, 
allowing you to namespace your component attributes for different elements of your component.

### Basic Example

```php
<x-forms.input name="first_name"
               :label="__('Hello')"
               label:class="flex flex-col"
               label:for="#name-input"
               input:id="name-input"
               container:id="name-input-container" />
```
In your component view, access scoped attributes using the scope() method:

```php
// forms.input.blade.php
<div {{ $attributes->scope('container')->merge(['class' => 'flex gap-y-2']) }}>
    
    @if($label)
        <label {{ $attributes->scope('label')->merge(['class' => 'text-gray-500']) }}>
            {{ $label }}
        </label>
    @endif

    <input {{ $attributes->scope('input')->merge(['class' => 'border-b']) }} />
</div>
```

### How It Works

The `scope()` method filters attributes based on the prefix. For example:
- The label's class in `label:class="font-bold"` becomes available when using `$attributes->scope('label')`
- The input's ID in `input:id="first-name-input"` becomes available when using `$attributes->scope('input')`
- The container's class in `container:class="mt-4"` becomes available when using `$attributes->scope('container')`

This allows you to:
1. Organize attributes for different elements/parts of your component
2. Create more intuitive component interfaces
3. Maintain cleaner component templates

### Benefits
- 🎯 Better organization of component attributes
- 🔍 More explicit attribute targeting
- 🧩 Cleaner components with less clutter
- 💪 Fully compatible with Laravel's existing attribute merging


> If you want to benifit from the `scope` method in your Blade views without installing this package, here is the magic sauce:

Add the following code to your `AppServiceProvider`:

```php
// AppServiceProvider.php
use Illuminate\View\ComponentAttributeBag;

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

```

## Contributing

Thank you for considering contributing to `Scopes for Laravel Blade Components`! The contribution guide can be found in the [CONTRIBUTING.md](CONTRIBUTING.md) file.

---
`Scopes for Laravel Blade Components` is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.


