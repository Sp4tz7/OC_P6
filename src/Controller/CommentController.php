<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/trick/{id}/comment/add", name="add-comment", methods={"POST"})
     */
    public function add(Request $request, TrickRepository $trickRepository, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $trick = $trickRepository->find($id);
        if (!$trick) {
            throw $this->createNotFoundException('This trick does not exists');
        }

        if ($this->isCsrfTokenValid('add'.$trick->getId(), $request->get('_token'))) {
            $comment = new Comment();
            $comment->setAuthor($this->getUser());
            $comment->setTrick($trick);
            $comment->setDateAdd(new \DateTime());
            $comment->setMessage($request->get('message'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return new JsonResponse(['success' => 'Comment added'], 200);
        }

        return new JsonResponse(['error' => 'Token Invalid'], 400);
    }
}
