<?php

namespace Spatie\Php7to5\PhpParser;

use PhpParser\Lexer;
use PhpParser\Parser\Tokens;

class KeepOriginalValueLexer extends Lexer // or Lexer\Emulative
{
    public function getNextToken(&$value = null, &$startAttributes = null, &$endAttributes = null): int
    {
        $tokenId = parent::getNextToken($value, $startAttributes, $endAttributes);

        // DEBUG
        //var_dump($tokenId, $value);

        if ($tokenId == Tokens::T_CONSTANT_ENCAPSED_STRING) {
            $endAttributes['originalValue'] = '_+*-7-to-5-*+_' . $value . '_+*-7-to-5-*+_';
        }

        return $tokenId;
    }
}
