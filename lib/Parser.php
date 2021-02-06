<?php

namespace Phpactor\Docblock;

use Phpactor\Docblock\Ast\Tag\DeprecatedTag;
use Phpactor\Docblock\Ast\Docblock;
use Phpactor\Docblock\Ast\Tag\MethodTag;
use Phpactor\Docblock\Ast\Tag\MixinTag;
use Phpactor\Docblock\Ast\ParameterList;
use Phpactor\Docblock\Ast\Tag\ParameterTag;
use Phpactor\Docblock\Ast\Tag\PropertyTag;
use Phpactor\Docblock\Ast\Tag\ReturnTag;
use Phpactor\Docblock\Ast\TextNode;
use Phpactor\Docblock\Ast\TypeList;
use Phpactor\Docblock\Ast\Type\ClassNode;
use Phpactor\Docblock\Ast\Node;
use Phpactor\Docblock\Ast\Tag\ParamTag;
use Phpactor\Docblock\Ast\TagNode;
use Phpactor\Docblock\Ast\TypeNode;
use Phpactor\Docblock\Ast\Type\GenericNode;
use Phpactor\Docblock\Ast\Type\ListNode;
use Phpactor\Docblock\Ast\Type\NullNode;
use Phpactor\Docblock\Ast\Type\NullableNode;
use Phpactor\Docblock\Ast\Type\ScalarNode;
use Phpactor\Docblock\Ast\Type\ThisNode;
use Phpactor\Docblock\Ast\Type\UnionNode;
use Phpactor\Docblock\Ast\UnknownTag;
use Phpactor\Docblock\Ast\ValueNode;
use Phpactor\Docblock\Ast\Value\NullValue;
use Phpactor\Docblock\Ast\Tag\VarTag;
use Phpactor\Docblock\Ast\VariableNode;
use Phpactor\Docblock\Ast\Token;
use Phpactor\Docblock\Ast\Tokens;

final class Parser
{
    /**
     * TODO Callable is not a scalar.
     */
    private const SCALAR_TYPES = [
        'int', 'float', 'bool', 'string', 'mixed', 'callable',
    ];

    /**
     * @var Tokens
     */
    private $tokens;

    public function parse(Tokens $tokens): Node
    {
        $children = [];
        $this->tokens = $tokens;

        while ($tokens->hasCurrent()) {
            if ($tokens->current->type === Token::T_TAG) {
                $children[] = $this->parseTag();
                continue;
            }
            $children[] = $tokens->chomp();
        }

        if (count($children) === 1) {
            $node = reset($children);
            if ($node instanceof Node) {
                return $node;
            }
        }

        return new Docblock($children);
    }

    private function parseTag(): TagNode
    {
        $token = $this->tokens->current;

        switch ($token->value) {
            case '@param':
                return $this->parseParam();

            case '@var':
                return $this->parseVar();

            case '@deprecated':
                return $this->parseDeprecated();

            case '@method':
                return $this->parseMethod();

            case '@property':
                return $this->parseProperty();

            case '@mixin':
                return $this->parseMixin();

            case '@return':
                return $this->parseReturn();
        }

        return new UnknownTag($this->tokens->chomp());
    }

    private function parseParam(): ParamTag
    {
        $type = $variable = $textNode = null;
        $tag = $this->tokens->chomp(Token::T_TAG);

        if ($this->ifType()) {
            $type = $this->parseTypes();
        }

        if ($this->tokens->ifNextIs(Token::T_VARIABLE)) {
            $variable = $this->parseVariable();
        }

        return new ParamTag($tag, $type, $variable, $this->parseText());
    }

    private function parseVar(): VarTag
    {
        $tag = $this->tokens->chomp(Token::T_TAG);
        $type = $variable = null;
        if ($this->ifType()) {
            $type = $this->parseTypes();
        }
        if ($this->tokens->ifNextIs(Token::T_VARIABLE)) {
            $variable = $this->parseVariable();
        }

        return new VarTag($tag, $type, $variable);
    }

    private function parseMethod(): MethodTag
    {
        $tag = $this->tokens->chomp(Token::T_TAG);
        $type = $name = $parameterList = $open = $close = null;
        $static = null;

        if ($this->tokens->ifNextIs(Token::T_LABEL)) {
            if ($this->tokens->current->value === 'static') {
                $static = $this->tokens->chomp();
            }
        }

        if ($this->ifType()) {
            $type = $this->parseTypes();
        }

        if ($this->tokens->if(Token::T_LABEL)) {
            $name = $this->tokens->chomp();
        }

        if ($this->tokens->if(Token::T_PAREN_OPEN)) {
            $open = $this->tokens->chomp(Token::T_PAREN_OPEN);
            $parameterList = $this->parseParameterList();
            $close = $this->tokens->chompIf(Token::T_PAREN_CLOSE);
        }

        return new MethodTag($tag, $type, $name, $static, $open, $parameterList, $close, $this->parseText());
    }

    private function parseProperty(): PropertyTag
    {
        $tag = $this->tokens->chomp(Token::T_TAG);
        $type = $name = null;
        if ($this->ifType()) {
            $type = $this->parseTypes();
        }
        if ($this->tokens->ifNextIs(Token::T_VARIABLE)) {
            $name = $this->tokens->chomp();
        }

        return new PropertyTag($tag, $type, $name);
    }

    private function parseTypes(): ?TypeNode
    {
        $type = $this->parseType();
        if (null === $type) {
            return $type;
        }
        $elements = [$type];

        while (true) {
            if ($this->tokens->if(Token::T_BAR)) {
                $elements[] = $this->tokens->chomp();
                $elements[] = $this->parseType();
                if (null !== $type) {
                    continue;
                }
            }
            break;
        }

        if (count($elements) === 1) {
            return $elements[0];
        }

        return new UnionNode(new TypeList($elements));
    }

    private function parseType(): ?TypeNode
    {
        if (null === $this->tokens->current) {
            return null;
        }

        if ($this->tokens->current->type === Token::T_NULLABLE) {
            $nullable = $this->tokens->chomp();
            return new NullableNode($nullable, $this->parseTypes());
        }

        $type = $this->tokens->chomp(Token::T_LABEL);

        if (null === $this->tokens->current) {
            return $this->createTypeFromToken($type);
        }

        $isList = false;

        if ($this->tokens->current->type === Token::T_LIST) {
            $list = $this->tokens->chomp();
            return new ListNode($this->createTypeFromToken($type), $list);
        }

        if ($this->tokens->current->type === Token::T_BRACKET_ANGLE_OPEN) {
            $open = $this->tokens->chomp();
            if ($this->tokens->if(Token::T_LABEL)) {
                $typeList = $this->parseTypeList();
            }

            if ($this->tokens->current->type !== Token::T_BRACKET_ANGLE_CLOSE) {
                return null;
            }

            return new GenericNode(
                $open,
                $this->createTypeFromToken($type),
                $typeList,
                $this->tokens->chomp()
            );
        }

        return $this->createTypeFromToken($type);
    }

    private function createTypeFromToken(Token $type): TypeNode
    {
        if (strtolower($type->value) === 'null') {
            return new NullNode($type);
        }
        if (in_array($type->value, self::SCALAR_TYPES)) {
            return new ScalarNode($type);
        }

        return new ClassNode($type);
    }

    private function parseVariable(): ?VariableNode
    {
        if ($this->tokens->current->type !== Token::T_VARIABLE) {
            return null;
        }

        $name = $this->tokens->chomp(Token::T_VARIABLE);

        return new VariableNode($name);
    }

    private function parseTypeList(string $delimiter = ','): TypeList
    {
        $types = [];
        while (true) {
            if ($this->tokens->if(Token::T_LABEL)) {
                $types[] = $this->parseTypes();
            }
            if ($this->tokens->if(Token::T_COMMA)) {
                $types[] = $this->tokens->chomp();
                continue;
            }
            break;
        }

        return new TypeList($types);
    }

    private function parseParameterList(): ?ParameterList
    {
        if ($this->tokens->if(Token::T_PAREN_CLOSE)) {
            return null;
        }

        $parameters = [];
        while (true) {
            $parameters[] = $this->parseParameter();
            if ($this->tokens->if(Token::T_COMMA)) {
                $parameters[] = $this->tokens->chomp();
                continue;
            }
            break;
        }

        return new ParameterList($parameters);
    }

    private function parseParameter(): ParameterTag
    {
        $type = $name = $default = null;
        if ($this->tokens->if(Token::T_LABEL)) {
            $type = $this->parseTypes();
        }
        if ($this->tokens->if(Token::T_VARIABLE)) {
            $name = $this->parseVariable();
        }
        if ($this->tokens->if(Token::T_EQUALS)) {
            $equals = $this->tokens->chomp();
            $default = $this->parseValue();
        }
        return new ParameterTag($type, $name, $default);
    }

    private function parseDeprecated(): DeprecatedTag
    {
        return new DeprecatedTag(
            $this->tokens->chomp(Token::T_TAG),
            $this->parseText()
        );
    }

    private function parseMixin(): MixinTag
    {
        $tag = $this->tokens->chomp(Token::T_TAG);
        $type = null;

        if ($this->tokens->if(Token::T_LABEL)) {
            $type = $this->parseTypes();
            if (!$type instanceof ClassNode) {
                $type = null;
            }
        }

        return new MixinTag($tag, $type);
    }

    private function parseReturn(): ReturnTag
    {
        $tag = $this->tokens->chomp(Token::T_TAG);
        $type = null;

        if ($this->tokens->if(Token::T_LABEL)) {
            $type = $this->parseTypes();
        }

        if ($this->tokens->if(Token::T_VARIABLE)) {
            $variable = $this->tokens->chomp(Token::T_VARIABLE);
            if ($variable->value === '$this') {
                $type = new ThisNode($variable);
            }
        }

        return new ReturnTag($tag, $type, $this->parseText());
    }

    private function parseText(): ?TextNode
    {
        if (null === $this->tokens->current) {
            return null;
        }

        $text = [];

        if (
            $this->tokens->current->type === Token::T_WHITESPACE &&
            $this->tokens->next()->type === Token::T_LABEL
        ) {
            $this->tokens->chomp();
        }

        while ($this->tokens->current) {
            if ($this->tokens->current->type === Token::T_PHPDOC_CLOSE) {
                break;
            }
            if ($this->tokens->current->type === Token::T_PHPDOC_LEADING) {
                break;
            }
            if (false !== strpos($this->tokens->current->value, "\n")) {
                break;
            }
            $text[] = $this->tokens->chomp();
        }
        
        if ($text) {
            return new TextNode($text);
        }

        return null;
    }

    private function ifType(): bool
    {
        return $this->tokens->if(Token::T_LABEL) || $this->tokens->if(Token::T_NULLABLE);
    }

    private function parseValue(): ?ValueNode
    {
        if ($this->tokens->if(Token::T_LABEL)) {
            if (strtolower($this->tokens->current->value) === 'null') {
                return new NullValue($this->tokens->chomp());
            }
        }

        return null;
    }
}
