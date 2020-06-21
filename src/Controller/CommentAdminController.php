<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     */
    public function index(CommentRepository $repository)
    {

        $comments = $repository->findBy([], ['createdAt' => 'DESC']);
        return $this->render('comment_admin/index.html.twig', [
            'comments' => $comments,
        ]);
    }
}
