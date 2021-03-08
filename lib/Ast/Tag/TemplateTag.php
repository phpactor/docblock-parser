<?php

namespace Phpactor\DocblockParser\Ast\Tag;

use Phpactor\DocblockParser\Ast\TagNode;
use Phpactor\DocblockParser\Ast\Token;
use Phpactor\DocblockParser\Ast\TypeNode;

class TemplateTag extends TagNode
{
    protected const CHILD_NAMES = [
        'tag',
        'placeholder',
        'constraint',
        'type'
    ];

    /**
     * @var Token
     */
    public $tag;
    /**
     * @var Token|null
     */
    public $placeholder;

    /**
     * @var Token|null
     */
    public $constraint;

    /**
     * @var TypeNode|null
     */
    public $type;

    public function __construct(Token $tag, ?Token $placeholder = null, ?Token $constraint = null, ?TypeNode $type = null)
    {
        $this->tag = $tag;
        $this->placeholder = $placeholder;
        $this->constraint = $constraint;
        $this->type = $type;
    }
}
