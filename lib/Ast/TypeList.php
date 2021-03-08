<?php

namespace Phpactor\DocblockParser\Ast;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use RuntimeException;

/**
 * @template T of Element
 * @implements IteratorAggregate<int,T>
 */
class TypeList extends Node implements IteratorAggregate, Countable
{
    protected const CHILD_NAMES = [
        'list'
    ];

    /**
     * @var array<T>
     */
    public $list;

    /**
     * @param array<T> $list
     */
    public function __construct(array $list)
    {
        $this->list = $list;
    }

    /**
     * @return ArrayIterator<int, T>
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

    /**
     * @return T
     */
    public function first(): Element
    {
        if (!isset($this->list[0])) {
            throw new RuntimeException(sprintf(
                'List has no first element'
            ));
        }

        return $this->list[0];
    }

    /**
     * @return TypeList<TypeNode&T>
     */
    public function types(): self
    {
        return new self(array_filter($this->list, function (Element $element) {
            return $element instanceof TypeNode;
        }));
    }
}
