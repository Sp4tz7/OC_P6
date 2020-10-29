<?php

namespace App\Service;

use App\Entity\Image;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            throw new \Exception($e->getMessage());
        }

        return $fileName;
    }

    public function remove(Filesystem $filesystem, Image $file)
    {
        $filesystem->remove($this->getTargetDirectory().'/'.$file->getFilename());
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
