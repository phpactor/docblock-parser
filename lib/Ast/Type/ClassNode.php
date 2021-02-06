<?php

namespace Phpactor\Docblock\Ast\Type;

use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\Token;

class ClassNode extends TypeNode
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

    public function name(): Token
    {
        return $this->name;
    }
}
