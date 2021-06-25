<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;

return (new Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'blank_line_before_statement' => false,
        'native_constant_invocation' => false,
        'native_function_invocation' => false,
        'no_extra_blank_lines' => [
            'tokens' => [
                'break',
                'continue',
                'curly_brace_block',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'throw',
            ],
        ],
        'ordered_imports' => [
            'imports_order' => [
                OrderedImportsFixer::IMPORT_TYPE_CLASS,
                OrderedImportsFixer::IMPORT_TYPE_FUNCTION,
                OrderedImportsFixer::IMPORT_TYPE_CONST,
            ],
            'sort_algorithm' => OrderedImportsFixer::SORT_ALPHA,
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'phpdoc_separation' => false,
        'phpdoc_summary' => false,
        'phpdoc_var_without_name' => false,
        'strict_param' => true,
        'yoda_style' => false,
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        Finder::create()
            ->in([__DIR__.'/src', __DIR__.'/tests'])
            ->append([__FILE__]),
    );
