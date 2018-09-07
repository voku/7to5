<?php

declare(strict_types=1);

namespace Spatie\Php7to5;

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use Spatie\Php7to5\Exceptions\InvalidParameter;
use Spatie\Php7to5\PhpParser\KeepOriginalValueLexer;
use Spatie\Php7to5\PhpParser\KeepOriginalValuePrinter;

class Converter
{
    /** @var string */
    protected $pathToPhp7Code;

    /**
     * @param string $pathToPhp7Code
     *
     * @throws \Spatie\Php7to5\Exceptions\InvalidParameter
     */
    public function __construct($pathToPhp7Code)
    {
        if (!file_exists($pathToPhp7Code)) {
            throw InvalidParameter::fileDoesNotExist($pathToPhp7Code);
        }

        $this->pathToPhp7Code = $pathToPhp7Code;
    }

    /**
     * @param string $destination
     */
    public function saveAsPhp5($destination)
    {
        file_put_contents($destination, $this->getPhp5Code());
    }

    /**
     * @return string
     */
    public function getPhp5Code(): string
    {
        ini_set('xdebug.max_nesting_level', '9000');

        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7, (new KeepOriginalValueLexer()));

        $php7code = file_get_contents($this->pathToPhp7Code);

        $php7Statements = $parser->parse($php7code);

        $traverser = self::getTraverser();

        $php5Statements = $traverser->traverse($php7Statements);

        return (new KeepOriginalValuePrinter())->prettyPrintFile($php5Statements);
    }

    /**
     * @return \PhpParser\NodeTraverser
     */
    public static function getTraverser(): NodeTraverser
    {
        $traverser = new NodeTraverser();

        foreach (glob(__DIR__ . '/NodeVisitors/*.php') as $nodeVisitorFile) {
            $className = pathinfo($nodeVisitorFile, PATHINFO_FILENAME);

            $fullClassName = '\\Spatie\\Php7to5\\NodeVisitors\\' . $className;

            $traverser->addVisitor(new $fullClassName());
        }

        return $traverser;
    }
}
