<?php

namespace Spatie\Php7to5\NodeVisitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/*
 * Converts define() arrays into const arrays
 */

class DefineArrayReplacer extends NodeVisitorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function afterTraverse(array $nodes)
    {
        foreach ($nodes as &$node) {

            if (!$node instanceof Node\Stmt\Expression) {
                continue;
            }

            if (!$node->expr instanceof Node\Expr\FuncCall) {
                continue;
            }

            if (!isset($node->expr->name)) {
                continue;
            }

            if ($node->expr->name->parts[0] != 'define') {
                continue;
            }

            $nameNode = $node->expr->args[0]->value;
            $valueNode = $node->expr->args[1]->value;

            if (!$valueNode instanceof Node\Expr\Array_) {
                continue;
            }

            $constNode = new Node\Const_($nameNode->value, $valueNode);

            $node = new Node\Stmt\Const_([$constNode]);
        }

        return $nodes;
    }
}
