<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Services\MailService;
use Doctrine\Common\Persistence\ObjectManager;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
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

    /**
     * @Route("/forgottenPassword",name="forgotten.password")
     */
    public function forgottenPassword(Request $request,ObjectManager $em,TokenGeneratorInterface $tokenGenerator,MailService $mailService) {

        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $user = $em->getRepository(User::class)->findOneByEmail($email);

            if ($user === null) {
                $this->addFlash('danger',"il n'y aucun utilisateur disponible pour cet email");

                return $this->redirectToRoute('forgotten.password');
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $em->flush();
            } catch (Exception $e) {
                $this->addFlash('warning',$e->getMessage());
                $this->redirectToRoute('forgotten.password');
            }

            $mailService->mail($user->getEmail(),'emails/reset_password_mail.html.twig',[
                'token' => $token
            ]);

            $this->addFlash('success','email envoyé');
        }

        return $this->render('security/forgotten_password.html.twig');
    }

    /**
     * @Route("/resetPassword/{token}",name="reset.password")
     */
    public function resetPassword(Request $request,ObjectManager $em,UserPasswordEncoderInterface $encoder,string $token) {

        if ($request->isMethod('POST')) {

            $user = $em->getRepository(User::class)->findOneByResetToken($token);

            if ($user === null) {
                $this->addFlash('danger','Token Inconnu');
                return $this->redirectToRoute('login');
            }

            $user->setResetToken(null);
            $password = $encoder->encodePassword($user,$request->request->get('password'));
            $user->setPassword($password);

            $em->flush();
            $this->addFlash('success','Mot de passe mis a jour');

            return $this->redirectToRoute('main');

        } else {

            return $this->render('security/reset_password.html.twig',[
                'token' => $token
            ]);
        }

    }


}
