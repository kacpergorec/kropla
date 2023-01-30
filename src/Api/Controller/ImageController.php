<?php
declare (strict_types=1);

namespace App\Api\Controller;

use App\Api\Errors\ApiError;
use App\Form\ImageType;
use App\Repository\PageRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;


#[Route('api', name: "api_")]
class ImageController extends AbstractFOSRestController
{

    #[Rest\Get('/images', name: "images_index")]
    public function getImages(): JsonResponse
    {

        $finder = new Finder();
        $finder->files()
            ->in($this->getParameter('upload_images_path'));

        $files = [];


        foreach ($finder->files() as $file) {
            $files[] = $this->getParameter('upload_images_directory') . '/' . $file->getRelativePathname();
        }

        return $this->json($files);
    }

    #[Rest\Post('/images', name: "images_upload")]
    public function uploadImages(Request $request): JsonResponse
    {
        $baseUrl = $request->getSchemeAndHttpHost();
        $file = $request->files->get('upload');

        //Decided to disable CSRF protection here because the app is now using JWT to validate the api requests
        $form = $this->createForm(ImageType::class, null , [
            'csrf_protection' => false,
        ]);

        $form->submit(['image' => $file]);

        //Form validation to JSON response (CKEditor5 Schema)
        if (!$form->isValid()) {
            $message = $form->getErrors(true)->current()->getMessage();
            return $this->json((new ApiError($message))->getError(), 400);
        }

        $uploadUrl = $baseUrl . $this->getParameter('upload_images_directory') . '/' . $file->getClientOriginalName();

        try {
            $file->move(
                $this->getParameter('upload_images_path'),
                $file->getClientOriginalName()
            );
        } catch (FileException $e) {
            return $this->json((new ApiError('Could not save file: ' . $file->getClientOriginalName() . '. ' . $e))->getError(), 400);
        }

        return $this->json([
            'url' => $uploadUrl
        ]);
    }
}