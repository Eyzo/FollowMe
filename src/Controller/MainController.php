<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\MyProfileType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ObjectManager $manager)
    {
        $profiles = $manager->getRepository(Profile::class)->findProfilesMainPage();


        return $this->render('main/index.html.twig', [
            'profiles' => $profiles,
        ]);
    }

    /**
     * @Route("/followers",name="my.followers")
     */
    public function myFollowers(ObjectManager $em) {

        $profile = $this->getUser()->getProfile();

        $subscribersId = $profile->getSubscribers();

        $subscribers = [];

        foreach ($subscribersId as $subscriberId){

            $subscribers[] = $em->getRepository(Profile::class)->find($subscriberId);

        }

        return $this->render('main/followers.html.twig',[
            'subscribers' => $subscribers
        ]);

    }

    /**
     * @Route("/follows",name="my.follows")
     */
    public function myFollows(ObjectManager $em) {

        $profile = $this->getUser()->getProfile();

        $subscribesId = $profile->getSubscribe();

        $subscribes = [];

        foreach ($subscribesId as $subscribeId) {

            $subscribes[] = $em->getRepository(Profile::class)->find($subscribeId);

        }

        return $this->render('main/follows.html.twig',[
            'subscribes' => $subscribes
        ]);
    }

    /**
     *@Route("/profile",name="user.profile")
     */
    public function seeProfile() {


        return $this->render('main/profile.html.twig');
    }


    /**
     * @Route("/myprofile",name="my.profile")
     */
    public function seeMyProfile(Request $request,ObjectManager $em) {

        $profile = $this->getUser()->getProfile();

        if ($profile) {

            $status = 'edit';

            $form = $this->createForm(MyProfileType::class, $profile);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $this->addFlash('success', 'le profile a bien été modifier');

                $em->flush();


            }
        } else {

            $status = 'new';

            $profile = new Profile();

            $form = $this->createForm(MyProfileType::class,$profile);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $profile->setUser($this->getUser());

                $this->getUser()->setProfile($profile);

                $this->addFlash('success','Votre Profile a bien était créer');

                $em->persist($profile);

                $em->flush();
            }

        }

        return $this->render('main/myprofile.html.twig',[
            'form' => $form->createView(),
            'profile' => $profile,
            'status' => $status
        ]);

    }

    /**
     * @Route("/page/{id}",name="page")
     */
    public function page(ObjectManager $em,int $id) {

        $profiles = $em->getRepository(Profile::class)->findOtherElements($id);

        if (empty($profiles)) {
            return new Response('',Response::HTTP_NOT_FOUND);
        }

        return $this->render('main/cards.html.twig',[
            'profiles' => $profiles
        ]);

    }

    /**
     * @Route("/search_profile/ajax",name="search.ajax")
     */
    public function searchProfilesAjax(Request $request,ObjectManager $em) {

        $search = trim($request->query->get('profile'));

        $profiles = $em->getRepository(Profile::class)->search($search);

        dump($profiles);


        return $this->render('search/result.html.twig',[
            'profiles' => $profiles
        ]);
    }


}
