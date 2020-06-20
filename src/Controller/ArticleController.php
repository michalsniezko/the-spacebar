<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Nexy\Slack\Client;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /** @var MarkdownHelper */
    private $markdownHelper;
    /**
     * @var SlackClient
     */
    private $slackClient;

    /**
     * ArticleController constructor.
     * @param MarkdownHelper $markdownHelper
     * @param SlackClient $slackClient
     */
    public function __construct(MarkdownHelper $markdownHelper, SlackClient $slackClient)
    {
        $this->markdownHelper = $markdownHelper;
        $this->slackClient = $slackClient;
    }

    /**
     * @Route("/", name="app_homepage")
     * @param ArticleRepository $repository
     * @return Response
     */
    public function homepage(ArticleRepository $repository)
    {
        return $this->render('article/homepage.html.twig', [
            'articles' => $repository->findAllPublishedOrderedByNewest(),
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     * @param Article $article
     * @return Response
     */
    public function show(Article $article)
    {
        if ($article->getSlug() === 'khan') {
            $this->slackClient->sendMessage('Khan', 'This is my message now!');
        }

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Wohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted!');
        // TODO - actually heart/unheart the article

        return $this->json(['hearts' => rand(5, 100)]);
    }
}