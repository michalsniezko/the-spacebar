<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('cached_markdown', [AppRuntime::class, 'processMarkdown'], ['is_safe' => ['html']]),
        ];
    }
}
