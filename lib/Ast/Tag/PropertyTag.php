<?php

namespace Phpactor\DocblockParser\Ast\Tag;

use Phpactor\DocblockParser\Ast\TagNode;
use Phpactor\DocblockParser\Ast\Token;
use Phpactor\DocblockParser\Ast\TypeNode;

class PropertyTag extends TagNode
{
    protected const CHILD_NAMES = [
        'tag',
        'type',
        'name',
    ];

    /**
     * @var TypeNode|null
     */
    public $type;

    /**
     * @var Token|null
     */
    public $name;

    /**
     * @var Token
     */
    public $tag;

    public function __construct(Token $tag, ?TypeNode $type, ?Token $name)
    {
        $this->type = $type;
        $this->name = $name;
        $this->tag = $tag;
    }
}
