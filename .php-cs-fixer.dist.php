<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor', 'tools', 'node_modules'])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony'                    => true,
        // Imports
        'ordered_imports'             => ['sort_algorithm' => 'alpha'],
        'no_unused_imports'           => true,
        // Lisibilité
        'array_syntax'                => ['syntax' => 'short'],
        'trailing_comma_in_multiline' => true,
    ])
    ->setFinder($finder)
    ;
