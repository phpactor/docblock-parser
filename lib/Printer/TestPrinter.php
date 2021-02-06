<?php

namespace Phpactor\Docblock\Printer;

use Phpactor\Docblock\Ast\Element;
use Phpactor\Docblock\Ast\Node;
use Phpactor\Docblock\Printer;
use Phpactor\Docblock\Ast\Token;

final class TestPrinter implements Printer
{
    /**
     * @var string[]
     */
    private $out = [];

    /**
     * @var int
     */
    private $indent = 0;

    public function print(Node $node): string
    {
        $this->indent++;
        $out = sprintf('%s: = ', $node->shortName());
        foreach ($node->children() as $child) {
            $out .= $this->printElement($child);
        }
        $this->indent--;

        return $out;
    }

    /**
     * @param Element|Element[] $element
     */
    public function printElement($element): string
    {
        if ($element instanceof Token) {
            return sprintf('%s', $element->value);
        }

        if ($element instanceof Node) {
            return $this->newLine() . $this->print($element);
        }

        return implode('', array_map(function (Element $element) {
            return $this->printElement($element);
        }, (array)$element));
    }

    private function newLine(): string
    {
        return "\n".str_repeat(' ', $this->indent);
    }
}
