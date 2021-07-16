# laravel-flexible-content
Base library for repeated layout fields, content builders and other collection components

## Docs (under construction)

- Installation & base use cases
- layouts registration
    - `register($layout, $limit)`
- get all registered layouts
    - `layouts()`
- limiting layouts
    - `limit($instances)`
    - `$layout->limit($instances)`
- building instances
    - `build($data)`
    - `buildUsing($callback)`
    - `insert($key, $attributes, $index, $id)`
- get all inserted instances, and manipulate the LayoutCollection :
    - `instances()`
    - `$instances->find($key)`
    - `$instances->whereKey($key)`
    - `$instances->whereKeyNot($key)`
    - `$instances->whereKeyIn($key)`
    - `$instances->whereKeyNotIn($key)`
- counting instances
    - `count($key = null)`

## Testing

This library uses [PestPHP](https://pestphp.com/). If you're considering contributing, please make sure all existing tests are still valid and that your changes are fully covered **before submitting a PR**.

Once installed, run the tests using `./vendor/bin/pest`.
