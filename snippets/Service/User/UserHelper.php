<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\Admin\RoleRepository;
use App\Repository\UserRepository;

class UserHelper
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getUserByUsername(?string $username): ?User
    {
        if ($username == null) return null;

        return $this->getUserByUsername($username);
    }

    /*--------------------------------------------------------------------------
                                    VALIDATION
    --------------------------------------------------------------------------*/
    public function checkPhone(?string $phone): ?array
    {
        if ($phone == null) { return null; }

        $phone = preg_replace("/[^\d]/","",$phone);

        return (strlen($phone) == 10) ?
            null :
            [ 'phone' => 'Phone number is 10 digits - 123-456-7890 or 1234567890'];
    }

    public function checkZip(?string $zip): ?array
    {
        if ($zip == null) { return null; }
        return (preg_match('/^\d{5}(-\d{4})?$/', $zip)) ?
            null :
            [ 'zip' => 'Zip code must be either 5 digits or 9 digits with or without the dash - 12345 or 123456789 or 12345-6789' ];
    }

    public function checkCity(?string $city): ?array
    {
        if ($city == null) { return null; }
       return strlen($city) > 40 ?
           [ 'city' => 'City name must contain 40 or fewer characters.'] :
           null;
    }

    public function checkStreetAddress(?string $street): ?array
    {
        if ($street == null) {return null;}
        return strlen($street) > 70 ?
            [ 'streetAddress' => 'Street name and number cannot contain more than 70 characters' ] :
            null;
    }

    public function checkBranches(array $branches): ?array
    {
        if (count($branches) == 0) { return null; }
        //branches are hard wired in, but will need to have their own entity
        $BRANCHES = [
            "Buffalo",
            "Monticello",
            "Zimmerman"
        ];

        // set all branches in branches to Uppercase first letter, rest lowercase
        for ($b = 0; $b < count($branches); $b++) {
            $branches[$b] = ucwords(strtolower($branches[$b]));
        }

        $intersect = array_intersect($BRANCHES, $branches);

        if (count($intersect) == count($branches)) {

            return null;
        }

        $diff = array_diff($branches, $BRANCHES);
        $error = "Branches had the following error(s): ";
        for ($d = 0; $d < count($diff); $d++) {
            if ($d > 0 ) {
                $error .= ", " . $diff[$d];
            } else {
                $error .= $diff[$d];
            }
        }
        return [ "branches" => $error ];

    }

    public function checkUsername(?string $username): ?array
    {
        if ($username == null) {
            return ['username' => 'Every user must have a username!'];
        }

        return (strlen($username) > 180) ?
            ['username' => 'Username is way too long, be less creative!'] :
            null;
    }

    public function checkFirstname(?string $first): ?array
    {
        if ($first == null) return null;

        return (strlen($first) > 30) ?
            ['firstname' => 'Your first name is too long'] :
            null;
    }

    public function checkLastname(?string $last): ?array
    {
        if ($last == null) return null;

        return (strlen($last) > 40) ?
            ['lastname' => 'Your last name is too long'] :
            null;
    }

    public function checkRoles(array $roles): ?array
    {
        if (count($roles) < 1) { return ['roles' => 'Must have at least one role']; }
        $errors = [];
        $roleNames = [];
        $realRoles = $this->roleRepository->findAllRoleNames();
        foreach($realRoles as $role) {
            $roleNames[] = $role["name"];
        }
        $intersect = array_intersect($roles, $roleNames);

        if (count($intersect) <> count($roles)) {
            $amount = abs(count($intersect) - count($roles));
            $errors['roles'] = "At least " . $amount . " of your roles are not actual roles.";
        }
        return $errors;

    }
}
