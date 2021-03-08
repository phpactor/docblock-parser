<?php

namespace Phpactor\DocblockParser\Ast;

class VariableNode extends Node
{
    protected const CHILD_NAMES = [
        'name'
    ];

    /**
     * @var Token
     */
    public $name;

    public function __construct(Token $name)
    {
        $this->name = $name;
    }

    public function name(): Token
    {
        return $this->name;
    }
}
