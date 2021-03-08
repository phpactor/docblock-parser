<?php

namespace Phpactor\DocblockParser\Ast\Tag;

use Phpactor\DocblockParser\Ast\TagNode;
use Phpactor\DocblockParser\Ast\Type\ClassNode;
use Phpactor\DocblockParser\Ast\Token;

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
