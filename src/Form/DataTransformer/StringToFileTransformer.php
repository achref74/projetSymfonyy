<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StringToFileTransformer implements DataTransformerInterface
{
    private $uploadDirectory;

    public function __construct(string $uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function transform($value): ?File
    {
        if (null === $value) {
            return null;
        }

        return new File($this->uploadDirectory.'/'.$value);
    }

    public function reverseTransform($value): ?string
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof UploadedFile) {
            $originalName = pathinfo($value->getClientOriginalName(), PATHINFO_FILENAME);
            $fileName = $originalName.'-'.uniqid().'.'.$value->guessExtension();

            try {
                $value->move($this->uploadDirectory, $fileName);
            } catch (FileException $e) {
                // Handle the exception
            }

            return $fileName;
        }

        return $value;
    }
}


