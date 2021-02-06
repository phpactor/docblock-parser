<?php

namespace Phpactor\Docblock\Ast\Tag;

use Phpactor\Docblock\Ast\TagNode;
use Phpactor\Docblock\Ast\TextNode;
use Phpactor\Docblock\Ast\Token;
use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\VariableNode;

class ParamTag extends TagNode
{
    protected const CHILD_NAMES = [
        'tag',
        'type',
        'variable',
        'text',
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
     * @var TextNode|null
     */
    public $text;

    /**
     * @var Token
     */
    public $tag;

    public function __construct(Token $tag, ?TypeNode $type, ?VariableNode $variable, ?TextNode $text = null)
    {
        $this->type = $type;
        $this->variable = $variable;
        $this->text = $text;
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

    public function text(): ?TextNode
    {
        return $this->text;
    }
}
