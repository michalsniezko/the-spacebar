<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Security;

class MarkdownHelper
{
    /** @var MarkdownInterface */
    private $markdown;

    /** @var AdapterInterface */
    private $cache;

    /** @var LoggerInterface */
    private $logger;

    /** @var bool */
    private $isDebug;

    /** @var Security */
    private $security;

    /**
     * MarkdownHelper constructor.
     * @param MarkdownInterface $markdown
     * @param AdapterInterface $cache
     * @param LoggerInterface $markdownLogger
     * @param bool $isDebug
     * @param Security $security
     */
    public function __construct(
        MarkdownInterface $markdown,
        AdapterInterface $cache,
        LoggerInterface $markdownLogger,
        bool $isDebug,
        Security $security
    ) {
        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $markdownLogger;
        $this->isDebug = $isDebug;
        $this->security = $security;
    }

    /**
     * @param string $source
     * @return string
     * @throws InvalidArgumentException
     */
    public function parse(string $source): string
    {
        if (stripos($source, 'bacon') !== false) {
            $this->logger->info('They\'re talking about bacon again!', [
                'user' => $this->security->getUser(),
            ]);
        }

        if ($this->isDebug) {
            return $this->markdown->transform($source);
        }

        $item = $this->cache->getItem('markdown_' . md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
