<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     */
    public function index()
    {
        return $this->render('comment_admin/index.html.twig', [
            'controller_name' => 'CommentAdminController',
        ]);
    }
}
