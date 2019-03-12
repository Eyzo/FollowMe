<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    /**
     * @Route("/follow/subscribe/{id}", name="subscribe")
     */
    public function Follow(User $user,ObjectManager $em)
    {
        if (!$this->getUser())
        {
            $this->addFlash('danger','Vous devez être connecté pour follow cette personne');

            return $this->redirectToRoute('app_login');
        }

        $currentProfile = $this->getUser()->getProfile();

        $currentProfile->setSubscribe($user->getProfile()->getId());

        $user->getProfile()->setSubscribers($currentProfile->getId());

        $em->flush();

        return $this->json([
            'subscribe' => True,
            'account' => $currentProfile->getName(),
            'follow' => $user->getProfile()->getName(),
            'count_followers' => count($user->getProfile()->getSubscribers())
        ]);
    }

    /**
     * @Route("/follow/unsubscribe/{id}",name="unsubscribe")
     */
    public function unFollow(User $user,ObjectManager $em) {

        if (!$this->getUser()) {

            $this->addFlash('danger','Vous devez être connecté pour unFollow cette personne');

            return $this->redirectToRoute('app_login');

        }

        $currentProfile = $this->getUser()->getProfile();

        $currentProfile->removeSubscribe($user->getProfile()->getId());

        $user->getProfile()->removeSubscribers($currentProfile->getId());

        $em->flush();

        return $this->json([
            'subscribe' => True,
            'account' => $currentProfile->getName(),
            'follow' => $user->getProfile()->getName(),
            'count_followers' => count($user->getProfile()->getSubscribers())
        ]);

    }
}
