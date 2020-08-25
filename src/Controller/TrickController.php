<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickNewType;
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

            $oldImage = $trick->getImage();
            $imageFile = $form['image']->getData();
            if ($imageFile) {
                $filename = md5(uniqid()).'.'.$imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('tricks_img_directory'),
                    $filename
                );
                if ($oldImage) {
                    $filesystem->remove($this->getParameter('avatar_img_directory').'/'.$oldImage);
                }
                $trick->setImage($filename);
            }

            $entityManager->persist($trick);
            $entityManager->flush();

            $trick = new Trick();
            $form = $this->createForm(TrickNewType::class, $trick);

            $this->addFlash('success', 'New trick has been added');
        }

        return $this->render('trick/new.html.twig', [
            'controller_name' => 'TrickController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/tricks", name="admin-tricks")
     */
    public function adminList(TrickRepository $trickRepository)
    {
        return $this->render('trick/admin-list.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    /**
     * @Route("/tricks", name="tricks")
     */
    public function list(TrickRepository $trickRepository)
    {
        return $this->render('trick/list.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(TrickRepository $trickRepository)
    {
        return $this->render('trick/list.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }
}
