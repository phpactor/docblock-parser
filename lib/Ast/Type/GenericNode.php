<?php

namespace Phpactor\Docblock\Ast\Type;

use Phpactor\Docblock\Ast\TypeList;
use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\Token;

class GenericNode extends TypeNode
{
    protected const CHILD_NAMES = [
        'type',
        'open',
        'parameters',
        'close'
    ];
    /**
     * @var Token
     */
    public $open;

    /**
     * @var Token
     */
    public $close;

    /**
     * @var TypeList
     */
    public $parameters;

    /**
     * @var TypeNode
     */
    public $type;

    public function __construct(Token $open, TypeNode $type, TypeList $parameters, Token $close)
    {
        $this->open = $open;
        $this->close = $close;
        $this->parameters = $parameters;
        $this->type = $type;
    }

    public function close(): Token
    {
        return $this->close;
    }

    public function open(): Token
    {
        return $this->open;
    }

    public function parameters(): TypeList
    {
        return $this->parameters;
    }

    public function type(): TypeNode
    {
        return $this->type;
    }
}
