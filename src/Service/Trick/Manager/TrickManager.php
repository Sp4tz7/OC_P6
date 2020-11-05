<?php

namespace App\Service\Trick\Manager;

use App\Entity\Trick;
use App\Service\FileUploader;
use App\Service\SlugManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Security;

class TrickManager
{
    private $fileUploader;
    private $entityManager;
    private $container;
    private $slugManager;
    private $originalImages = [];
    private $security;

    public function __construct(
        FileUploader $fileUploader,
        EntityManagerInterface $entityManager,
        SlugManager $slugManager,
        ContainerInterface $container,
        Security $security
    ) {
        $this->fileUploader = $fileUploader;
        $this->entityManager = $entityManager;
        $this->container = $container;
        $this->slugManager = $slugManager;
        $this->security = $security;
    }

    public function setOriginalImages($images)
    {
        $originalImages = new ArrayCollection();
        foreach ($images as $image) {
            $originalImages->set($image->getId(), ['file_name' => $image->getFileName(), 'image_object' => $image]);
        }
        $this->originalImages = $originalImages;
    }

    public function create(Trick $trick, $form)
    {
        $trick->setDateAdd(new \DateTime());
        $trick->setAddedBy($this->security->getUser());

        $this->persist($trick, $form);
    }

    private function persist(Trick $trick, $form)
    {
        $trick->setSlug($this->slugManager->slugThis($trick->getName()));

        $imageFile = $form['image']->getData();

        if ($imageFile) {
            $filename = $this->fileUploader->upload($imageFile);
            $trick->setImage($filename);
        }

        foreach ($trick->getImages() as $image) {
            // An image already exists and we need the original file name because the input file doesn't send it
            if (null !== $image->getId() && null === $image->getFileName() && null !== $this->originalImages[$image->getId()]) {
                $image->setFileName($this->originalImages[$image->getId()]['file_name']);
                continue;
            }
            // New image has been set
            if (null === $image->getId() && null !== $image->getFileName()) {
                $filename = $this->fileUploader->upload($image->getFileName());
                $image->setFileName($filename);
                $trick->addImage($image);
                continue;
            }
        }

        // remove image if deleted
        foreach ($this->originalImages as $key => $originalImage) {
            $image = $originalImage['image_object'];
            if (false === $trick->getImages()->contains($image)) {
                $this->fileUploader->remove($image);
            }
        }

        $this->entityManager->persist($trick);
        $this->entityManager->flush();
    }

    public function update(Trick $trick, $form)
    {
        $trick->setDateEdit(new \DateTime());
        $trick->setEditedBy($this->security->getUser());

        $this->persist($trick, $form);
    }
}
