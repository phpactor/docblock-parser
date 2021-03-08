<?php

namespace Phpactor\DocblockParser\Ast\Tag;

use Phpactor\DocblockParser\Ast\TagNode;
use Phpactor\DocblockParser\Ast\TextNode;
use Phpactor\DocblockParser\Ast\Token;
use Phpactor\DocblockParser\Ast\TypeNode;

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
