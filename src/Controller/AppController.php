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
        return $this->render('app/index.html.twig', [
            'photos' => $this->getDoctrine()->getRepository(Photo::class)->findAll(),
            'rootDir' => $this->container->get('kernel')->getRootDir(),
            'controller_name' => 'AppController',
        ]);
    }
}
