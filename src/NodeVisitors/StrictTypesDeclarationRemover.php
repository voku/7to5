<?php

namespace Spatie\Php7to5\NodeVisitors;

use PhpParser\Node;
use PhpParser\Node\Stmt\DeclareDeclare;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

class StrictTypesDeclarationRemover extends NodeVisitorAbstract
{
    /**
     * {@inheritdoc}
     */
    public function leaveNode(Node $node)
    {
        if (!$node instanceof DeclareDeclare) {
            return;
        }

        if ($node->key->name === 'strict_types') {
            return NodeTraverser::REMOVE_NODE;
        }
    }
}
