<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\Admin\RoleRepository;

class RoleHelper
{

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param string|null $roleName
     * @return bool
     * returns true if $roleName is a valid role name
     * false otherwise
     * roleName needs to be formatted correctly prior to test
     */
    public function isValid(?string $roleName): bool
    {
        if ($roleName == null) { return false; }

        return ($this->roleRepository->findRoleName($roleName) != null);
    }

    /**
     * @param array $roles
     * @return bool
     * return true if all roles in the $roles array are role names
     * false otherwise
     * role names in $roles must already be formatted prior to test
     */
    public function areRolesValid(array $roles): bool
    {
        if (count($roles) < 1) { return false; }

        $validRoles = $this->roleRepository->findAllRoleNames();
        $validNames = [];
        foreach($validRoles as $role) {
            array_push($validNames, $role["name"]);
        }

        $intersect = array_intersect($roles, $validNames);

        return count(array_diff($roles, $intersect)) == 0;
    }

    /**
     * @param string|null $name
     * @return string|null
     * returns $name properly formatted as a role name
     * if role_ is not the first 5 characters, then it is add
     * and the whole thing is capitalized.
     * returns null if null was given to be formatted
     */
    public function formatName(?string $name): ?string
    {
        if ($name == null) { return $name; }

        $name = strtoupper(str_replace(" ", "_", $name));

        if (!strpos($name, "ROLE_")) {
            $name = "ROLE_" . $name;
        }
        return $name;
    }

    /**
     * @return array
     * returns all of the role names in a single array format
     * if there are no roles yet, then it returns an empty array
     */
    public function findAllNames(): array
    {
        $roughNames = $this->roleRepository->findAllRoleNames();
        $roleNames = [];
        foreach($roughNames as $names) {
            array_push($roleNames, $names["name"]);
        }
        return $roleNames;
    }

    /**
     * @return array
     * returns an array or Role or an empty array
     */
    public function getAllRoles(): array
    {
        return $this->roleRepository->findAll();
    }

    public function getRolesForUser(int $id): array
    {

        return [];
    }
}
