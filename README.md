# laravel-flexible-content

This package's only purpose is to build custom repeated layout components, such as [Laravel Nova's Flexible Content field](https://github.com/whitecube/nova-flexible-content) or your own content builders and manageable component collections. It is meant to provide a tested and multi-purpose backend API that should be extended by specific components (regardless of their frontend stack).

## Docs (under construction)

- Installation & base use cases
- layouts registration
    - `register($layout, $limit)`
- get all registered layouts
    - `layouts()`
    - `layoutsMenu()`
- limiting layouts
    - `limit($instances)`
    - `$layout->limit($instances)`
- building instances
    - `build($data)`
    - `buildUsing($callback)`
    - `insert($key, $attributes, $index, $id)`
- serializing the flexible container's state
    - `serialize()`
    - `serializeAs($format)`
    - `serializeUsingFormat($format)`
    - `serializeUsing($callback)`
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
