<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Hello! This is a homepage.');
    }

    /**
     * @Route("/news/{slug}")
     * @param string $slug
     * @return Response
     */
    public function show(string $slug)
    {
        return new Response(
            sprintf(
                'Future page to show the article: %s',
                ucwords(str_replace('-', ' ', $slug))
            )
        );
    }
}