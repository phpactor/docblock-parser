<?php

namespace Phpactor\Docblock\Ast\Type;

use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\Token;

class NullNode extends TypeNode
{
    protected const CHILD_NAMES = [
        'null',
    ];

    /**
     * @var Token
     */
    public $null;

    public function __construct(Token $null)
    {
        $this->null = $null;
    }

    public function null(): Token
    {
        return $this->null;
    }
}
