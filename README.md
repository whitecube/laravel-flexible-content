# laravel-flexible-content
Base library for repeated layout fields, content builders and other collection components

## Docs (under construction)

- Installation & base use cases
- layouts registration
- get all registered layouts
- limiting layouts count (global & layout-specific)
- inserting instances
- get all inserted instances, and manipulate the LayoutCollection :
    - `find($key)`
    - `whereKey($key)`
    - `whereKeyNot($key)`
    - `whereKeyIn($key)`
    - `whereKeyNotIn($key)`
- counting instances

## Testing

This library uses [PestPHP](https://pestphp.com/). If you're considering contributing, please make sure all existing tests are still valid and that your changes are fully covered **before submitting a PR**.

Once installed, run the tests using `./vendor/bin/pest`.
