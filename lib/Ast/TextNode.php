<?php

namespace Phpactor\Docblock\Ast;

class TextNode extends Node
{
    protected const CHILD_NAMES = [
        'tokens',
    ];

    /**
     * @var Token[]
     */
    public $tokens;

    /**
     * @param Token[] $tokens
     */
    public function __construct(array $tokens)
    {
        $this->tokens = $tokens;
    }

    public function toString(): string
    {
        return implode('', array_map(function (Token $token) {
            return $token->value;
        }, $this->tokens));
    }
}
