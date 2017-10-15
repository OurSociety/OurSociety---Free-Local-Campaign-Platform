<?php
declare(strict_types=1);

$config = PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        'blank_line_before_statement' => true,
        'declare_equal_normalize' => true,
        'ordered_imports' => true,
        'ordered_class_elements' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('tests/Fixtures')
            ->in(__DIR__)
    );

return $config;
