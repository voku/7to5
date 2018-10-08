<?php

namespace Spatie\Php7to5\PhpParser;

use PhpParser\Node;
use PhpParser\PrettyPrinter\Standard;

class KeepOriginalValuePrinter extends Standard
{
    /**
     * Pretty prints an array of nodes (statements) and indents them optionally.
     *
     * @param Node[] $nodes Array of nodes
     * @param bool $indent Whether to indent the printed nodes
     *
     * @return string Pretty printed statements
     */
    protected function pStmts(array $nodes, bool $indent = true) : string
    {
        return parent::pStmts($nodes, $indent);
    }

    protected function pScalar_String(Node\Scalar\String_ $node)
    {
        $str = $node->getAttribute('originalValue');

        $str = str_replace(
            ['"_+*-7-to-5-*+_', '_+*-7-to-5-*+_"', '_+*-7-to-5-*+_'],
            ['"', '"', ''],
            $str
        );

        return $str;
    }
}
