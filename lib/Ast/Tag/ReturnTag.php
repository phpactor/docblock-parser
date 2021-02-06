<?php

namespace Phpactor\Docblock\Ast\Tag;

use Phpactor\Docblock\Ast\TagNode;
use Phpactor\Docblock\Ast\TextNode;
use Phpactor\Docblock\Ast\Token;
use Phpactor\Docblock\Ast\TypeNode;

class ReturnTag extends TagNode
{
    protected const CHILD_NAMES = [
        'tag',
        'type',
        'text',
    ];

    /**
     * @var TypeNode|null
     */
    public $type;

    /**
     * @var TextNode|null
     */
    public $text;

    /**
     * @var Token
     */
    public $tag;

    public function __construct(Token $tag, ?TypeNode $type, ?TextNode $text = null)
    {
        $this->type = $type;
        $this->text = $text;
        $this->tag = $tag;
    }

    public function type(): ?TypeNode
    {
        return $this->type;
    }

    public function text(): ?TextNode
    {
        return $this->text;
    }
}
