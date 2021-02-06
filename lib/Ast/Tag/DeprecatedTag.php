<?php

namespace Phpactor\Docblock\Ast\Tag;

use Phpactor\Docblock\Ast\TagNode;
use Phpactor\Docblock\Ast\TextNode;
use Phpactor\Docblock\Ast\Token;

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
