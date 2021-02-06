<?php

namespace Phpactor\Docblock\Ast\Value;

use Phpactor\Docblock\Ast\ValueNode;
use Phpactor\Docblock\Ast\Token;

class NullValue extends ValueNode
{
    /**
     * @var Token
     */
    private $null;

    public function __construct(Token $null)
    {
        $this->null = $null;
    }

    public function null(): Token
    {
        return $this->null;
    }

    /**
     * {@inheritDoc}
     */
    public function value()
    {
        return null;
    }
}
