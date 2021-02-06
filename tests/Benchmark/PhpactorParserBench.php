<?php

namespace Phpactor\Docblock\Tests\Benchmark;

use Phpactor\Docblock\Lexer;
use Phpactor\Docblock\Parser;

class PhpactorParserBench extends AbstractParserBenchCase
{
    /**
     * @var PhpDocParser
     */
    private $parser;
    /**
     * @var Lexer
     */
    private $lexer;

    public function setUp(): void
    {
        $this->parser = new Parser();
        $this->lexer = new Lexer();
    }
    public function parse(string $doc): void
    {
        $this->parser->parse($this->lexer->lex($doc));
    }
}
