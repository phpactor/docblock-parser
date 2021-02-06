<?php

namespace Phpactor\Docblock\Ast\Type;

use Phpactor\Docblock\Ast\Token;
use Phpactor\Docblock\Ast\TypeNode;

class ThisNode extends TypeNode
{
    protected const CHILD_NAMES = [
        'name'
    ];

    /**
     * @var Token
     */
    public $name;

    public function __construct(Token $name)
    {
        $this->name = $name;
    }
}
