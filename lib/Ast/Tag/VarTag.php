<?php

namespace Phpactor\DocblockParser\Ast\Tag;

use Phpactor\DocblockParser\Ast\TagNode;
use Phpactor\DocblockParser\Ast\Token;
use Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor\DocblockParser\Ast\VariableNode;

class VarTag extends TagNode
{
    protected const CHILD_NAMES = [
        'tag',
        'type',
        'variable',
    ];
    /**
     * @var ?TypeNode
     */
    public $type;

    /**
     * @var ?VariableNode
     */
    public $variable;

    /**
     * @var Token
     */
    public $tag;

    public function __construct(Token $tag, ?TypeNode $type, ?VariableNode $variable)
    {
        $this->type = $type;
        $this->variable = $variable;
        $this->tag = $tag;
    }

    public function type(): ?TypeNode
    {
        return $this->type;
    }

    public function variable(): ?VariableNode
    {
        return $this->variable;
    }
}
