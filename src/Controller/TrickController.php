<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickNewType;
use App\Repository\TrickCategoryRepository;
use App\Repository\TrickRepository;
use App\Service\SlugManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/admin/trick/add", name="trick-add")
     */
    public function trickAdd(Request $request, SlugManager $slugManager, Filesystem $filesystem)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickNewType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $trick->setDateAdd(new \DateTime());
            $trick->setSlug($slugManager->slugThis($trick->getName()));
            $trick->setAddedBy($this->getUser());

            $imageFile = $form['image']->getData();
            $imageDirectory = $this->getParameter('tricks_img_directory');
            if ($imageFile) {
                $filename = md5(uniqid()).'.'.$imageFile->guessExtension();
                $imageFile->move($imageDirectory, $filename);
                $trick->setImage($filename);
            }

            $entityManager->persist($trick);
            $entityManager->flush();

            $trick = new Trick();
            $form = $this->createForm(TrickNewType::class, $trick);

            $this->addFlash('success', 'New trick has been added');
        }

        return $this->render(
            'trick/new.html.twig',
            [
                'controller_name' => 'TrickController',
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/trick/delete/{id}", name="trick-delete", methods="DELETE")
     */
    public function trickDelete(Request $request, TrickRepository $trickRepository, Filesystem $filesystem, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $trick = $trickRepository->find($id);
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->get('_token'))) {
            $filesystem->remove($this->getParameter('tricks_img_directory').'/'.$trick->getImage());
            foreach ($trick->getImages() as $image) {
                $filesystem->remove($this->getParameter('tricks_img_directory').'/'.$image->getFileName());
            }

            $em->remove($trick);
            $em->flush();
        }
        $this->addFlash('success', 'Trick has been deleted');

        return $this->redirectToRoute('admin-tricks');
    }

    /**
     * @Route("/admin/trick/edit/{id}", name="trick-edit")
     */
    public function trickEdit(Request $request, SlugManager $slugManager, Filesystem $filesystem, TrickRepository $trickRepository, $id)
    {
        $trick = $trickRepository->find($id);

        if (!$trick) {
            throw $this->createNotFoundException('This trick does not exists');
        }

        $form = $this->createForm(TrickNewType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $trick->setDateEdit(new \DateTime());
            $trick->setSlug($slugManager->slugThis($trick->getName()));
            $trick->setEditedBy($this->getUser());

            $oldImage = $trick->getImage();
            $imageFile = $form['image']->getData();
            $imageDirectory = $this->getParameter('tricks_img_directory');

            if ($imageFile) {
                $filename = md5(uniqid()).'.'.$imageFile->guessExtension();
                $imageFile->move($imageDirectory, $filename);

                if ($oldImage) {
                    $filesystem->remove($imageDirectory.'/'.$oldImage);
                }

                $trick->setImage($filename);
            }

            $imagesFile = $form['images']->getData();
            if ($imagesFile) {
                foreach ($imagesFile as $imageFile) {
                    $filename = md5(uniqid()).'.'.$imageFile->guessExtension();
                    $imageFile->move($imageDirectory, $filename);

                    $image = new Image();
                    $image->setName($filename);
                    $image->setFileName($filename);
                    $image->setTrick($trick);
                    $entityManager->persist($image);
                    $entityManager->flush();
                }
            }

            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'New trick has been edited');
        }

        return $this->render(
            'trick/edit.html.twig',
            [
                'trick' => $trick,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/admin/tricks", name="admin-tricks")
     */
    public function adminList(TrickRepository $trickRepository)
    {
        return $this->render(
            'trick/admin-list.html.twig',
            [
                'tricks' => $trickRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/tricks", name="tricks")
     */
    public function list(TrickRepository $trickRepository, TrickCategoryRepository $trickCategoryRepository)
    {
        return $this->render(
            'trick/list.html.twig',
            [
                'tricks' => $trickRepository->findAll(),
                'categories' => $trickCategoryRepository->findAll(),
            ]);
    }

    /**
     * @Route("/trick/{category}/{trick}", name="show-trick")
     */
    public function showTrick(TrickRepository $trickRepository, $category, $trick)
    {
        $trick = $trickRepository->findOneBy(['slug' => $trick]);
        if (!$trick) {
            throw $this->createNotFoundException('This trick does not exists');
        }

        $form = $this->createForm(CommentType::class);

        return $this->render(
            'trick/trick.html.twig',
            [
                'trick' => $trick,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/tricks/{category}", name="category-tricks")
     */
    public function showTricksCategory(TrickCategoryRepository $trickCategoryRepository, $category)
    {
        $category = $trickCategoryRepository->findOneBy(['slug' => $category]);
        if (!$category) {
            throw $this->createNotFoundException('This category does not exists');
        }

        return $this->render(
            'trick/category.html.twig',
            [
                'category' => $category,
            ]
        );
    }

    /**
     * @Route("/", name="home")
     */
    public function home(TrickRepository $trickRepository)
    {
        return $this->render(
            'trick/list.html.twig',
            [
                'tricks' => $trickRepository->findAll(),
            ]
        );
    }
}
