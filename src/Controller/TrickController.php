<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickCategoryRepository;
use App\Repository\TrickRepository;
use App\Service\Trick\Manager\TrickManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    private $trickManager;

    public function __construct(TrickManager $trickManager)
    {
        $this->trickManager = $trickManager;
    }

    /**
     * @Route("/admin/trick/add", name="admin-trick-add")
     */
    public function trickAdd(Request $request)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->trickManager->create($trick, $form['image']->getData());

            $this->addFlash('success', 'New trick has been added');

            return $this->redirectToRoute('admin-trick-list');
        }

        return $this->render(
            'backend/trick/new.html.twig',
            [
                'controller_name' => 'TrickController',
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/trick/delete/{id}/{token}/", name="admin-trick-delete", methods="DELETE")
     */
    public function trickDelete(TrickRepository $trickRepository, Filesystem $filesystem, $id, $token)
    {
        $em = $this->getDoctrine()->getManager();

        $trick = $trickRepository->find($id);

        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $token)) {
            $filesystem->remove($this->getParameter('tricks_img_directory').'/'.$trick->getImage());
            foreach ($trick->getImages() as $image) {
                $filesystem->remove($this->getParameter('tricks_img_directory').'/'.$image->getFileName());
            }

            $em->remove($trick);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }

        return new JsonResponse(['success' => 0]);
    }

    /**
     * @Route("/admin/trick/edit/{id}", name="admin-trick-edit")
     *
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function trickEdit(
        Request $request,
        TrickRepository $trickRepository,
        $id
    ) {
        $trick = $trickRepository->find($id);

        if (!$trick) {
            throw $this->createNotFoundException('This trick does not exists');
        }

        $this->trickManager->setOriginalImages($trick->getImages()->getValues());

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->trickManager->update($trick, $form['image']->getData());
            $this->addFlash('success', 'Trick has been edited');

            return $this->redirectToRoute('admin-trick-list');
        }

        return $this->render(
            'backend/trick/edit.html.twig',
            [
                'trick' => $trick,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/tricks", name="admin-trick-list")
     */
    public function adminList(TrickRepository $trickRepository)
    {
        return $this->render(
            'backend/trick/list.html.twig',
            [
                'tricks' => $trickRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/tricks", name="tricks")
     */
    public function List(
        TrickRepository $trickRepository,
        TrickCategoryRepository $trickCatRepository
    ) {
        return $this->render(
            'trick/list.html.twig',
            [
                'categories' => $trickCatRepository->findAll(),
                'tricks' => $trickRepository->findBy([], ['date_add' => 'DESC']),
            ]);
    }

    /**
     * @Route("/trick/{category}/{trick}", name="show-trick")
     */
    public function showTrick(TrickRepository $trickRepository, CommentRepository $commentRepository, $trick)
    {
        $trick = $trickRepository->findOneBy(['slug' => $trick]);
        if (!$trick) {
            throw $this->createNotFoundException('This trick does not exists');
        }

        $comments = $commentRepository->findBy(['trick' => $trick], ['date_add' => 'DESC']);
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('add-comment', ['id' => $trick->getId()]),
            'method' => 'POST',
        ]);

        return $this->render(
            'trick/trick.html.twig',
            [
                'trick' => $trick,
                'comments' => $comments,
                'CommentForm' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/tricks/{category}", name="category-tricks")
     */
    public function showTricksCat(TrickCategoryRepository $trickCatRepository, $category)
    {
        $category = $trickCatRepository->findOneBy(['slug' => $category]);
        if (!$category) {
            throw $this->createNotFoundException('This category does not exists');
        }

        return $this->render(
            'trick/list.html.twig',
            [
                'category' => $category,
                'tricks' => $category->getTricks(),
            ]
        );
    }

    /**
     * @Route("/", name="home")
     */
    public function home(TrickRepository $trickRepository)
    {
        return $this->render(
            'frontend/home.html.twig',
            [
                'tricks' => $trickRepository->findBy([], ['date_add' => 'DESC']),
                'class' => 'header-full',
            ]
        );
    }
}
