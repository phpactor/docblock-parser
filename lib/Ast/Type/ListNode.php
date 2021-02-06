<?php

namespace Phpactor\Docblock\Ast\Type;

use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\Token;

class ListNode extends TypeNode
{
    protected const CHILD_NAMES = [
        'type',
        'listChars',
    ];

    /**
     * @var TypeNode
     */
    public $type;

    /**
     * @var Token
     */
    public $listChars;

    public function __construct(TypeNode $type, Token $listChars)
    {
        $this->type = $type;
        $this->listChars = $listChars;
    }

    public function type(): TypeNode
    {
        return $this->type;
    }

    public function listChars(): Token
    {
        return $this->listChars;
    }
}
