<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    /**
     * @Route("/follow/subscribe/{id}", name="subscribe")
     */
    public function Follow(Profile $profile,ObjectManager $em)
    {

        if (!$this->getUser())
        {
            $this->addFlash('danger','Vous devez être connecté pour follow cette personne');

            return $this->redirectToRoute('app_login');
        }

        $currentProfile = $this->getUser()->getProfile();

        $currentProfile->setSubscribe($profile->getId());

        $profile->setSubscribers($currentProfile->getId());

        $em->flush();



        return $this->json([
            'subscribe' => True,
            'account' => $currentProfile->getName(),
            'follow' => $profile->getName(),
            'count_followers' => count($profile->getSubscribers())
        ]);
    }

    /**
     * @Route("/follow/unsubscribe/{id}",name="unsubscribe")
     */
    public function unFollow(Profile $profile,ObjectManager $em) {

        if (!$this->getUser()) {

            $this->addFlash('danger','Vous devez être connecté pour unFollow cette personne');

            return $this->redirectToRoute('app_login');

        }

        $currentProfile = $this->getUser()->getProfile();

        $currentProfile->removeSubscribe($profile->getId());

        $profile->removeSubscribers($currentProfile->getId());

        $em->flush();

        return $this->json([
            'subscribe' => False,
            'account' => $currentProfile->getName(),
            'follow' => $profile->getName(),
            'count_followers' => count($profile->getSubscribers())
        ]);

    }
}
