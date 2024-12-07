<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__) // Scan the entire project directory
    ->exclude('vendor') // Exclude the vendor folder
    ->exclude('storage') // Exclude storage folder
    ->exclude('node_modules') // Exclude node_modules folder
    ->notPath('bootstrap/cache') // Exclude specific paths if necessary
    ->name('*.php') // Only include PHP files
    ->ignoreDotFiles(true) // Ignore dotfiles
    ->ignoreVCS(true); // Ignore version control files (e.g., .git)

$config = new PhpCsFixer\Config();

return $config
    ->setFinder($finder)
    ->setRules([
        '@PSR12' => true, // Apply PSR-12 coding standard
        'array_syntax' => ['syntax' => 'short'], // Use short array syntax
        'single_quote' => true, // Prefer single quotes
        'no_unused_imports' => true, // Remove unused imports
        'ordered_imports' => ['sort_algorithm' => 'alpha'], // Alphabetically order imports
        // Add additional rules as needed
    ])
    ->setRiskyAllowed(true) // Allow risky rules
    ->setUsingCache(true); // Enable caching for performance
