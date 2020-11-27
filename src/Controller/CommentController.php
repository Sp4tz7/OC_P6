<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

        $data = $request->get('comment');

        if ($this->isCsrfTokenValid('comment', $data['_token'])) {
            $comment = new Comment();
            $comment->setAuthor($this->getUser());
            $comment->setTrick($trick);
            $comment->setDateAdd(new \DateTime());
            $comment->setMessage($data['message']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Comment saved');

            return $this->redirectToRoute('show-trick', [
                'category' => $trick->getCategory()[0]->getSlug(),
                'trick' => $trick->getSlug(),
                '_fragment' => 'comments',
            ]);
        }

        $this->addFlash('error', 'Token Invalid');

        return $this->redirectToRoute('show-trick', [
            'category' => $trick->getCategory()[0]->getSlug(),
            'trick' => $trick->getSlug(),
        ]);
    }

    /**
     * @Route("trick/comment/{id}/delete", name="delete-comment", methods="DELETE")
     *
     * @return RedirectResponse
     */
    public function delete(Comment $comment, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->get('_token'))) {
            $this->em->remove($comment);
            $this->em->flush();
        }

        return $this->redirectToRoute('trick-edit', ['id' => $comment->getTrick()->getId()]);
    }
}
