<?php

namespace App\Controller;

use App\Entity\Profile;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ObjectManager $manager)
    {
        $profiles = $manager->getRepository(Profile::class)->findAll();
        dump($profiles);

        return $this->render('main/index.html.twig', [
            'profiles' => $profiles,
        ]);
    }
}
