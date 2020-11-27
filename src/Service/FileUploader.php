<?php

namespace App\Service;

use App\Entity\Image;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
    private $targetDirectory;

    private $filesystem;

    public function __construct($targetDirectory, Filesystem $filesystem )
    {
        $this->filesystem = $filesystem;
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(File $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            throw new \Exception($e->getMessage());
        }

        return $fileName;
    }

    public function remove( Image $file)
    {
        $this->filesystem->remove($this->getTargetDirectory().'/'.$file->getFilename());
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
