<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /** @var MarkdownHelper */
    private $markdownHelper;

    /** @var SlackClient */
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

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();

        $logger->info('Article is being hearted!');

        return $this->json(['hearts' => $article->getHeartCount()]);
    }
}
