<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader
{
    private $targetDirectory;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * FileUploader constructor.
     * @param $targetDirectory
     * @param Filesystem $fileSystem
     */
    public function __construct($targetDirectory, Filesystem $fileSystem)
    {
        $this->targetDirectory = $targetDirectory;
        $this->fileSystem = $fileSystem;
    }

//    public function upload(UploadedFile $file, $newFileName = null)
//    {
//        $fileName = uniqid() . '.' . $file->guessExtension();
//
//        if ($newFileName != null) {
//            $fileName = $newFileName . "." . $file->guessExtension();
//        }
//
//        try {
//            $file->move($this->getTargetDirectory(), $fileName);
//        } catch (FileException $e) {
//            // ... handle exception if something happens during file upload
//        }
//
//        return $fileName;
//    }

    public function upload(File $file, $newFileName = null)
    {
        $fileName = uniqid() . '.' . $file->guessExtension();

        if ($newFileName != null) {
            $fileName = $newFileName . "." . $file->guessExtension();
        }

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function setTargetDirectory($targetDirectory)
    {
        return $this->targetDirectory = $this->targetDirectory . $targetDirectory;
    }

    public function delete($filename)
    {
        if ($this->fileSystem->exists($this->targetDirectory . "/" . $filename)) {
            $this->fileSystem->remove($this->targetDirectory . "/" . $filename);
        }
    }
}