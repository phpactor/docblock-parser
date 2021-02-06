<?php

namespace Phpactor\Docblock\Ast;

use ArrayIterator;
use Countable;
use Generator;
use IteratorAggregate;
use Phpactor\Docblock\Ast\Tag\ParameterTag;

/**
 * @implements IteratorAggregate<ParameterNode>
 */
class ParameterList extends Node implements IteratorAggregate, Countable
{
    protected const CHILD_NAMES = [
        'list'
    ];

    /**
     * @var ParameterNode[]
     */
    public $list;

    /**
     * @param ParameterNode[] $list
     */
    public function __construct(array $list)
    {
        $this->list = $list;
    }

    /**
     * @return Generator<ParameterTag>
     */
    public function parameters(): Generator
    {
        foreach ($this->list as $element) {
            if ($element instanceof ParameterTag) {
                yield $element;
            }
        }
    }

    /**
     * @return ArrayIterator<int, ParameterNode>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->list);
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->list);
    }
}
