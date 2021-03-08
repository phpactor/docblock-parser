<?php

namespace Phpactor\DocblockParser\Ast\Tag;

use Phpactor\DocblockParser\Ast\TagNode;
use Phpactor\DocblockParser\Ast\TextNode;
use Phpactor\DocblockParser\Ast\Token;

class DeprecatedTag extends TagNode
{
    public const CHILD_NAMES = [
        'token',
        'text',
    ];

    /**
     * @var TextNode
     */
    public $text;

    /**
     * @var Token
     */
    public $token;

    public function __construct(Token $token, ?TextNode $text)
    {
        $this->text = $text;
        $this->token = $token;
    }
}
