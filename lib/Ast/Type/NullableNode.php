<?php

namespace Phpactor\Docblock\Ast\Type;

use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\Token;

class NullableNode extends TypeNode
{
    protected const CHILD_NAMES = [
        'nullable',
        'type',
    ];

    /**
     * @var Token
     */
    public $nullable;

    /**
     * @var TypeNode
     */
    public $type;

    public function __construct(Token $nullable, TypeNode $type)
    {
        $this->nullable = $nullable;
        $this->type = $type;
    }

    public function nullable(): Token
    {
        return $this->nullable;
    }

    public function type(): TypeNode
    {
        return $this->type;
    }
}
