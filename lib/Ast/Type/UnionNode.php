<?php

namespace Phpactor\Docblock\Ast\Type;

use Phpactor\Docblock\Ast\TypeList;
use Phpactor\Docblock\Ast\TypeNode;

class UnionNode extends TypeNode
{
    protected const CHILD_NAMES = [
        'types',
    ];

    /**
     * @var TypeList
     */
    public $types;

    public function __construct(TypeList $types)
    {
        $this->types = $types;
    }
}
