<?php

namespace Phpactor\DocblockParser\Ast\Value;

use Phpactor\DocblockParser\Ast\ValueNode;
use Phpactor\DocblockParser\Ast\Token;

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
