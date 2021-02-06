<?php

namespace Phpactor\Docblock;

use Phpactor\Docblock\Ast\Node;

interface Printer
{
    public function print(Node $node): string;
}
