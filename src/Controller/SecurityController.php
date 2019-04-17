<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{


    /**
     * @Route("/login", name="base_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="base_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/register", name="base_register")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             GuardAuthenticatorHandler $guardHandler,
                             LoginFormAuthenticator $formAuthenticator )
    {
        if ($request->isMethod('POST')) {
            $user = new User();
            $user->setUsername($request->request->get('username'));
            // make sure firstname and lastname are set or don't add them
            !empty($request->request->get('firstname')) ?
                $user->setFirstName($request->request->get('firstname')) :
                $user->setFirstName('');
            !empty($request->request->get('lastname')) ?
                $user->setLastName($request->request->get('lastname')) :
                $user->setLastName('');

            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $request->request->get('password')
            ));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $formAuthenticator,
                'main'
            );
        }
        return $this->render('security/register.html.twig');
    }

    /**
     * @Route("/superman")
     */
    public function superman() {
        /** @var User $user */
        $user = $this->getUser();
        $user->setRoles([
            "ROLE_SUPERMAN"
        ]);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->render('base/homepage.html.twig');
    }
}
