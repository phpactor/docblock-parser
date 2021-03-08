<?php

namespace Phpactor\DocblockParser\Ast\Tag;

use Phpactor\DocblockParser\Ast\TagNode;
use Phpactor\DocblockParser\Ast\TypeNode;
use Phpactor\DocblockParser\Ast\ValueNode;
use Phpactor\DocblockParser\Ast\VariableNode;

class ParameterTag extends TagNode
{
    protected const CHILD_NAMES = [
        'type',
        'name',
        'default',
    ];

    /**
     * @var TypeNode|null
     */
    public $type;

    /**
     * @var VariableNode|null
     */
    public $name;

    /**
     * @var ValueNode|null
     */
    public $default;

    public function __construct(?TypeNode $type, ?VariableNode $name, ?ValueNode $default)
    {
        $this->type = $type;
        $this->name = $name;
        $this->default = $default;
    }

    public function name(): ?VariableNode
    {
        return $this->name;
    }

    public function type(): ?TypeNode
    {
        return $this->type;
    }

    public function default(): ?ValueNode
    {
        return $this->default;
    }
}
