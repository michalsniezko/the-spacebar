<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    /**
     * @var MarkdownHelper
     */
    private $markdownHelper;

    public function __construct(MarkdownHelper $markdownHelper)
    {
        $this->markdownHelper = $markdownHelper;
    }

    public function processMarkdown($value)
    {
        return $this->markdownHelper->parse($value);
    }
}
