<?php

namespace Phpactor\Docblock\Ast\Tag;

use Phpactor\Docblock\Ast\TagNode;
use Phpactor\Docblock\Ast\Type\ClassNode;
use Phpactor\Docblock\Ast\Token;

class MixinTag extends TagNode
{
    protected const CHILD_NAMES = [
        'tag',
        'class'
    ];

    /**
     * @var ClassNode|null
     */
    public $class;

    /**
     * @var Token
     */
    public $tag;

    public function __construct(Token $tag, ?ClassNode $class)
    {
        $this->class = $class;
        $this->tag = $tag;
    }

    public function class(): ?ClassNode
    {
        return $this->class;
    }
}
