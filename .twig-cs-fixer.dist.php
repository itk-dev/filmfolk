<?php
// https://github.com/VincentLanglet/Twig-CS-Fixer/blob/main/docs/configuration.md#configuration-file

$finder = new TwigCsFixer\File\Finder();
// Check all files …
$finder->in(__DIR__);
// … that are not ignored by VSC
$finder->ignoreVCSIgnored(true);

$config = new TwigCsFixer\Config\Config();
$config->setFinder($finder);

return $config;
