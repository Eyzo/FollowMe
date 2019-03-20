<?php
namespace App\Services;

use Twig\Environment;

class MailService {


    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * MailService constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer,Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param string $to a qui l'envoyer
     * @param string $view la vue
     * @param array $parameters les paramètres
     */
    public function mail(string $to,string $view,array $parameters) {

        $message = new \Swift_Message('Hello Email');

        $message->setFrom('duhameltonysmtp@gmail.com');
        $message->setTo($to);
        $message->setBody(
            $this->twig->render($view,$parameters),'text/html'
        );

        $this->mailer->send($message);
    }




}