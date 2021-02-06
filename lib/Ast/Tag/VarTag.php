<?php

namespace Phpactor\Docblock\Ast\Tag;

use Phpactor\Docblock\Ast\TagNode;
use Phpactor\Docblock\Ast\Token;
use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\VariableNode;

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
