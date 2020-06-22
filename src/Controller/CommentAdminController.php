<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN_COMMENT")
 */
class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     * @param CommentRepository $repository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $repository->getAllWithSearchQueryBuilder($q);
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('comment_admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
