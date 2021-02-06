<?php

namespace Phpactor\Docblock\Ast\Tag;

use Phpactor\Docblock\Ast\TagNode;
use Phpactor\Docblock\Ast\Token;
use Phpactor\Docblock\Ast\TypeNode;

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
