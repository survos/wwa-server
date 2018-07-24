<?php

namespace App\Controller;

use App\Entity\Photo;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $template = 'unite-demo.html.twig'; // app/index.html.twig
        return $this->render($template, [
            'photos' => $this->getDoctrine()->getRepository(Photo::class)->findAll(),
        ]);
    }

    /**
     * @Route("/photo/{id}", name="photo_detail")
     */
    public function photo(Photo $photo)
    {
        return $this->render('app/photo.html.twig', [
            'photo' => $photo
        ]);
    }

}
