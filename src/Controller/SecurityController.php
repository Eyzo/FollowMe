<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout",name="app_logout")
     */
    public function logout() {

    }

    /**
     * @Route("/register",name="register")
     */
    public function register(Request $request,ObjectManager $em,UserPasswordEncoderInterface $encoder) {

        $user = new User();

        $form = $this->createForm(RegisterType::class,$user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success','Votre compte a bien été créer');

            $password = $encoder->encodePassword($user,$form->getData()->getPassword());

            $user->setPassword($password);

            $user->setRoles(array("ROLE_USER"));

            $em->persist($user);

            $em->flush();

            $token = new UsernamePasswordToken($user,null,'main',$user->getRoles());

            $this->container->get('security.token_storage')->setToken($token);
            $this->container->get('session')->set('_security_main',serialize($token));

            return $this->redirectToRoute('main');

        }

        return $this->render('security/register.html.twig',[
            'form' => $form->createView()
        ]);

    }
}
