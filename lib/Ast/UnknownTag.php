<?php

namespace Phpactor\DocblockParser\Ast;

class UnknownTag extends TagNode
{
    
    private Token $name;

    public function __construct(Token $name)
    {
        $this->name = $name;
    }
}
