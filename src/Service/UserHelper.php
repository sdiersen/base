<?php

namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;

class UserHelper
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getPossibleUserRoles(): array
    {
        return User::getPossibleUserRoles();
    }

    public function getPossibleUserRolesPretty(): array
    {
        $roles = User::getPossibleUserRoles();
        return $this->userRolesPretty($roles);
    }

    public function userRolesPretty(array $roles): array
    {
        $prettyRoles = [];
        foreach($roles as $role) {
            $temp = ltrim($role, "ROLE");
            $temp = ltrim($temp, "_");
            $temp = str_replace("_", " ", $temp);
            $temp = ucwords(strtolower($temp));
            $temp = str_replace("Gx", "GX", $temp);
            $temp = str_replace("Pt", "PT", $temp);
            $prettyRoles[] = $temp;
        }
        return $prettyRoles;
    }

    public function userIsSiteMember(User $user): bool
    {
        $roles = $user->getRoles();
        return array_search("ROLE_MEMBER", $roles) != null;
    }

    public function prettyRolesToRealRoles(array $pretty): array
    {
        $realRoles = [];
        foreach($pretty as $role) {
            $temp = "role " . $role;
            $temp = strtoupper($temp);
            $temp = str_replace(" ", "_", $temp);
            $realRoles[] = $temp;
        }
        return $realRoles;
    }

    public function assignRoles(array $newRoles): array
    {
        $userRoles = [];

        if (in_array("ROLE_MEMBER", $newRoles)) {
            $temp = $this->setMember();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_CLUB_MEMBER", $newRoles)) {
            $temp = $this->setClubMember();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_EMPLOYEE", $newRoles)) {
            $temp = $this->setEmployee();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_PT_TRAINER", $newRoles)) {
            $temp = $this->setPtTrainer();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_GX_INSTRUCTOR", $newRoles)) {
            $temp = $this->setGxInstructor();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_SWIM_INSTRUCTOR", $newRoles)) {
            $temp = $this->setSwimInstructor();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_PT_ADMIN", $newRoles)) {
            $temp = $this->setPtAdmin();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_GX_ADMIN", $newRoles)) {
            $temp = $this->setGxAdmin();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_SWIM_ADMIN", $newRoles)) {
            $temp = $this->setSwimAdmin();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_ADMIN", $newRoles)) {
            $temp = $this->setAdmin();
            $userRoles = array_merge($userRoles, $temp);
        }
        if (in_array("ROLE_SUPERMAN", $newRoles)) {
            $temp = $this->setSuperman();
            $userRoles = array_merge($userRoles, $temp);
        }

        $userRoles = array_unique($userRoles);

        if (count($userRoles) < 1) return ["ROLE_GUEST"];

        if (($key = in_array("ROLE_GUEST", $userRoles)) !== false) {
            unset($userRoles[$key]);
        }

        return $userRoles;
    }

    public function getUserUnassignedRoles(array $assignedRoles): array
    {
        $allRoles = User::getPossibleUserRoles();
        return array_diff($allRoles, $assignedRoles);
    }

    public function getUserUnassignedRolesPretty(array $assignedRoles): array
    {
        $unassignedRoles = $this->getUserUnassignedRoles($assignedRoles);
        return $this->userRolesPretty($unassignedRoles);
    }

    public function getAllUsersWithRole(string $role): array
    {
        $allUsers = $this->userRepository->findAll();
        $users = [];
        foreach($allUsers as $user) {
            if($this->hasRole($user, $role)) {
                $users[] = $user;
            }
        }
        return $users;
    }

    public function getAllUsersWithRoleLike(string $role): array
    {
        $allUsers = $this->userRepository->findAll();
        $users = [];
        foreach($allUsers as $user) {
            if($this->hasPartialRole($user, $role)) {
                $users[] = $user;
            }
        }
        return $users;
    }

    public function getNormalRoles(): array
    {
        return User::getNormalRoles();
    }

    public function getNormalRolesPretty(): array
    {
        return $this->userRolesPretty(User::getNormalRoles());
    }

    public function getEmployeeRoles(): array
    {
        return User::getEmployeeRoles();
    }

    public function getEmployeeRolesPretty(): array
    {
        return $this->userRolesPretty(User::getEmployeeRoles());
    }

    public function getAdminRoles(): array
    {
        return User::getAdminRoles();
    }

    public function getAdminRolesPretty(): array
    {
        return $this->userRolesPretty(User::getAdminRoles());
    }

    public function checkFirstName(string $first): array
    {
        if(strlen($first) > 30) {
            return ["firstName" => "You have a very long first name, try using a nickname instead."];
        }
        return [];
    }

    public function checkLastName(string $last): array
    {
        if(strlen($last) > 40) {
            return ["lastName" => "Your last name is too long for the record books. Have you ever thought of going by Smith?"];
        }
        return [];
    }

    public function checkUsername(string $username): array
    {
        $test = $this->userRepository->findByUsername($username);

        if ($test != null) {
            return ['username' => "Username already in use!"];
        }
        if (strlen($username) > 180) {
            return ['username' => 'Wow, that\'s a really long name! Try something shorter'];
        }
        return [];
    }

    public function checkPassword(string $pass1, string $pass2): array
    {
        if($pass1 != $pass2) {
            return ["password" => "Your passwords do not match."];
        }
        $hasErrors = false;
        $error = "Your password is missing at least one:\n";
        $uppercase = preg_match('@[A-Z]@', $pass1);
        $lowercase = preg_match('@[a-z]@', $pass1);
        $number = preg_match('@[0-9]@', $pass1);
        $special = preg_match('@[\W]@', $pass1);

        if($uppercase < 1) { $error .= "Uppercase letter\n"; $hasErrors = true;}
        if($lowercase < 1) { $error .= "Lowercase letter\n"; $hasErrors = true;}
        if($number < 1) {$error .= "Number\n"; $hasErrors = true;}
        if($special < 1) {$error .= "Special character\n"; $hasErrors = true;}

        if ($hasErrors) {
            return ["password" => $error];
        }
        return [];

    }

    public function checkRoles(array $roles): array
    {
        if (count($roles) < 1) { return ["roles" => "Every user needs at least 1 role."]; }
        return [];
    }

    public function passwordRules(): string
    {
        return "Your password must contain at least one:\nUppercase letter\nLowercase letter\nNumber\nSpecial character";
    }

    public function getUserById(?int $id): ?User
    {
        if ($id == null) { return null; }
        return $this->userRepository->findById($id);
    }

    //----------------------PRIVATE FUNCTIONS-----------------------//

    private function setSuperman(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_SWIM_ADMIN",
            "ROLE_PT_ADMIN",
            "ROLE_GX_ADMIN",
            "ROLE_ADMIN",
            "ROLE_SUPERMAN"
        ];
    }

    private function setAdmin(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_SWIM_ADMIN",
            "ROLE_PT_ADMIN",
            "ROLE_GX_ADMIN",
            "ROLE_ADMIN"
        ];
    }

    private function setSwimAdmin(): array
    {
        return  [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_SWIM_ADMIN"
        ];
    }

    private function setGxAdmin(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_GX_ADMIN"
        ];
    }

    private function setPtAdmin(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_PT_ADMIN"
        ];
    }

    private function setSwimInstructor(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_SWIM_INSTRUCTOR"
        ];
    }

    private function setGxInstructor(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_GX_INSTRUCTOR"
        ];
    }

    private function setPtTrainer(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE",
            "ROLE_PT_TRAINER"
        ];
    }

    private function setEmployee(): array
    {
        return [
            "ROLE_MEMBER",
            "ROLE_CLUB_MEMBER",
            "ROLE_EMPLOYEE"
        ];
    }

    private function setClubMember(): array
    {
        return [
            "ROLE_CLUB_MEMBER"
        ];
    }

    private function setMember(): array
    {
        return [
            "ROLE_MEMBER"
        ];
    }

    private function hasRole(User $user, string $role): bool
    {
        $roles = $user->getRoles();
        return in_array($role, $roles);
    }

    private function hasPartialRole(User $user, string $partial): bool
    {
        $roles = $user->getRoles();
        foreach($roles as $role)
        {
            if (strpos($role, $partial)) return true;
        }
        return false;
    }
}
