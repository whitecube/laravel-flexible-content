<?php

namespace Whitecube\LaravelFlexibleContent;

use Whitecube\LaravelFlexibleContent\Contracts\Flexible as FlexibleInterface;

class Flexible implements FlexibleInterface
{
    use Concerns\HasLayouts;
    use Concerns\HasLayoutInstances;
    use Concerns\HasResolver;
}
