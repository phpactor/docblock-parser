<?php

namespace Phpactor\Docblock\Ast;

abstract class ValueNode extends Node
{
    /**
     * @return mixed
     */
    abstract public function value();
}
