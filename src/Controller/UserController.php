<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(UserRepository $userRepository, UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        return $this->render('user/index.html.twig', [
            'prettyRoles' => $prettyRoles,
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @Route("/test", name="user_test")
     * @return Response
     */
    public function test(UserHelper $userHelper)
    {
        $errors = [];

        /**@var User $user */
        $user = $this->getUser();
        $roles = $userHelper->userRolesPretty($user->getRoles());

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'roles' => $roles,
            'errors' => $errors,
        ]);
    }

    /**
     * @Route("/superman")
     */
    public function superman()
    {
        /** @var User $user */
        $user = $this->getUser();
        $user->addRole("ROLE_SUPERMAN");
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param UserHelper $userHelper
     * @return Response
     */
    public function new(Request $request, UserHelper $userHelper, UserPasswordEncoderInterface $passwordEncoder) : Response
    {
        $user = new User();
        $normalRoles = $userHelper->getNormalRolesPretty();
        $employeeRoles = $userHelper->getEmployeeRolesPretty();
        $adminRoles = $userHelper->getAdminRolesPretty();
        $errors = [];

        if ($request->isMethod("POST")) {

            $first = $userHelper->checkFirstName($request->request->get("firstName"));
            count($first) == 0 ? $user->setFirstName($request->request->get("firstName")) : $errors = array_merge($errors, $first);

            $last = $userHelper->checkLastName($request->request->get("lastName"));
            count($last) == 0 ? $user->setLastName($request->request->get("lastName")) : $errors = array_merge($errors, $last);

            $username = $userHelper->checkUsername($request->request->get("username"));
            count($username) == 0 ? $user->setUsername($request->request->get("username")) : $errors = array_merge($errors, $username);

            $pass1 = $request->request->get("password");
            $pass2 = $request->request->get("repeatPassword");

            $password = $userHelper->checkPassword($pass1, $pass2);
            count($password) == 0 ? $user->setPassword($passwordEncoder->encodePassword($user, $pass1)) : $errors = array_merge($errors, $password);

            $roles = $userHelper->prettyRolesToRealRoles($request->request->get("role"));
            $role = $userHelper->checkRoles($roles);
            count($role) == 0 ? $user->setRoles($roles) : $errors = array_merge($errors, $role);

            if (count($errors) < 1) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('user_index');
            }


        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'errors' => $errors,
            'passwordRules' => $userHelper->passwordRules(),
            'normalRoles' => $normalRoles,
            'employeeRoles' => $employeeRoles,
            'adminRoles' => $adminRoles,
        ]);
    }

    /**
     * @param User $user
     * @return Response
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'roles' => []
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/siteMembers", name="user_show_site_members")
     */
    public function showSiteMembers(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRole("ROLE_MEMBER");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/clubMembers", name="user_show_club_members")
     */
    public function showClubMembers(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRole("ROLE_CLUB_MEMBER");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/Employees", name="user_show_employees")
     */
    public function showEmployees(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRole("ROLE_EMPLOYEE");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/GxInstructors", name="user_show_gx_instructors")
     */
    public function showGXInstructors(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRole("ROLE_GX_INSTRUCTOR");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/swimInstructors", name="user_show_swim_instructors")
     */
    public function showSwimInstructors(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRole("ROLE_SWIM_INSTRUCTOR");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/personalTrainers", name="user_show_personal_trainers")
     */
    public function showPersonalTrainers(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRole("ROLE_PT_TRAINER");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/admins", name="user_show_admins")
     */
    public function showAdmins(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRoleLike("ADMIN");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

    /**
     * @param UserHelper $userHelper
     * @return Response
     * @Route("/show/supermen", name="user_show_supermen")
     */
    public function showSupermen(UserHelper $userHelper): Response
    {
        $prettyRoles = $userHelper->getPossibleUserRolesPretty();
        $users = $userHelper->getAllUsersWithRole("ROLE_SUPERMAN");
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'prettyRoles' => $prettyRoles,
        ]);
    }

}
