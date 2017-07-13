<?php
declare(strict_types = 1);

namespace OurSociety\TestSuite;

use ScriptFUSION\PHPUnitImmediateExceptionPrinter as ImmediateException;

/** @noinspection LongInheritanceChainInspection */
class ResultPrinter extends ImmediateException\PhpUnit6Printer
{
    private const SEPARATOR = ' ▸ ';
    private const SYMBOLS = [
        '.' => '✅', // success
        'F' => '❌', // failure
        'E' => '🔥', // error
        'R' => '💀', // risky
        'S' => '🏳', // skipped
        'I' => '🚧', // incomplete
    ];

    /**
     * Rewrite test descriptions.
     *
     * @param string $test The original description ('Test\Namespace\Class::testMethod with data set "name" (data, ...)')
     * @return string The rewritten description ('Namespace ▸ Class ▸ Method ▸ Name')
     */
    protected function describeTest($test): string
    {
        $s = '\\\\';
        $description = parent::describeTest($test);
        $description = preg_replace("#^OurSociety${s}Test${s}TestCase${s}#", '', $description);
        $description = preg_replace('#Test::test#', $s, $description);
        $description = preg_replace("#${s}#", "${s}", $description);
        $description = preg_replace('# with data set "(.*?)"(.*)#', "${s}$1", $description);
        $description = implode(self::SEPARATOR, array_map(function (string $part) {
            return $this->camelToTitle(ucfirst($part));
        }, explode('\\', $description)));

        return $description;
    }

    /**
     * Rewrite progress indicators.
     *
     * @param string $progress The original progress indicator ('.')
     * @return void Sets the rewritten progress indicator ('✅')
     */
    protected function writeProgress($progress): void
    {
        foreach (self::SYMBOLS as $letter => $emoji) {
            $progress = str_replace($letter, $emoji, $progress);
        }

        parent::writeProgress($progress);
    }

    /**
     * Camel to title.
     *
     * @param string $camelString The camel string.
     * @return string The title string.
     */
    private function camelToTitle(string $camelString): string
    {
        $intermediate = preg_replace('/(?!^)([[:upper:]][[:lower:]]+)/', ' $0', $camelString);
        $titleString = preg_replace('/(?!^)([[:lower:]])([[:upper:]])/', '$1 $2', $intermediate);

        return $titleString;
    }
}
