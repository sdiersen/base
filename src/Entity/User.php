<?php

namespace App\Entity;

use App\Entity\Events\ScheduledEvent;
use App\Entity\Gx\ScheduledClass;
use App\Entity\Swim\ScheduledLesson;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;


    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Swim\ScheduledLesson", mappedBy="instructor")
     */
    private $scheduledLessons;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Events\ScheduledEvent", mappedBy="presenter")
     */
    private $scheduledEvents;

    private static $userRoles = [
        'ROLE_GUEST',
        'ROLE_MEMBER',
        'ROLE_CLUB_MEMBER',
        'ROLE_EMPLOYEE',
        'ROLE_ADMIN',
        'ROLE_SWIM_INSTRUCTOR',
        'ROLE_SWIM_ADMIN',
        'ROLE_GX_INSTRUCTOR',
        'ROLE_GX_ADMIN',
        'ROLE_PT_TRAINER',
        'ROLE_PT_ADMIN',
        'ROLE_SUPERMAN'
    ];

    private static $normalRoles = [
        "ROLE_GUEST",
        "ROLE_MEMBER",
        "ROLE_CLUB_MEMBER"
    ];

    private static $employeeRoles = [
        "ROLE_EMPLOYEE",
        "ROLE_SWIM_INSTRUCTOR",
        "ROLE_GX_INSTRUCTOR",
        "ROLE_PT_TRAINER"
    ];

    private static $adminRoles = [
        "ROLE_ADMIN",
        "ROLE_SWIM_ADMIN",
        "ROLE_GX_ADMIN",
        "ROLE_PT_ADMIN",
        "ROLE_SUPERMAN"
    ];

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Gx\ScheduledClass", mappedBy="instructor")
     */
    private $scheduledClasses;

    public function __construct()
    {
        $this->scheduledLessons = new ArrayCollection();
        $this->scheduledEvents = new ArrayCollection();
        $this->scheduledClasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterfaces
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        if (count($roles) < 1) {
            $roles[] = 'ROLE_GUEST';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): self
    {
        array_push($this->roles, $role);

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|ScheduledLesson[]
     */
    public function getScheduledLessons(): Collection
    {
        return $this->scheduledLessons;
    }

    public function addScheduledLesson(ScheduledLesson $scheduledLesson): self
    {
        if (!$this->scheduledLessons->contains($scheduledLesson)) {
            $this->scheduledLessons[] = $scheduledLesson;
            $scheduledLesson->setInstructor($this);
        }

        return $this;
    }

    public function removeScheduledLesson(ScheduledLesson $scheduledLesson): self
    {
        if ($this->scheduledLessons->contains($scheduledLesson)) {
            $this->scheduledLessons->removeElement($scheduledLesson);
            // set the owning side to null (unless already changed)
            if ($scheduledLesson->getInstructor() === $this) {
                $scheduledLesson->setInstructor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ScheduledEvent[]
     */
    public function getScheduledEvents(): Collection
    {
        return $this->scheduledEvents;
    }

    public function addScheduledEvent(ScheduledEvent $scheduledEvent): self
    {
        if (!$this->scheduledEvents->contains($scheduledEvent)) {
            $this->scheduledEvents[] = $scheduledEvent;
            $scheduledEvent->setPresenter($this);
        }

        return $this;
    }

    public function removeScheduledEvent(ScheduledEvent $scheduledEvent): self
    {
        if ($this->scheduledEvents->contains($scheduledEvent)) {
            $this->scheduledEvents->removeElement($scheduledEvent);
            // set the owning side to null (unless already changed)
            if ($scheduledEvent->getPresenter() === $this) {
                $scheduledEvent->setPresenter(null);
            }
        }

        return $this;
    }

    public static function getPossibleUserRoles(): array
    {
        return User::$userRoles;
    }

    public static function getNormalRoles(): array
    {
        return User::$normalRoles;
    }

    public static function getEmployeeRoles(): array
    {
        return User::$employeeRoles;
    }

    public static function getAdminRoles(): array
    {
        return User::$adminRoles;
    }

    /**
     * @return Collection|ScheduledClass[]
     */
    public function getScheduledClasses(): Collection
    {
        return $this->scheduledClasses;
    }

    public function addScheduledClass(ScheduledClass $scheduledClass): self
    {
        if (!$this->scheduledClasses->contains($scheduledClass)) {
            $this->scheduledClasses[] = $scheduledClass;
            $scheduledClass->addInstructor($this);
        }

        return $this;
    }

    public function removeScheduledClass(ScheduledClass $scheduledClass): self
    {
        if ($this->scheduledClasses->contains($scheduledClass)) {
            $this->scheduledClasses->removeElement($scheduledClass);
            $scheduledClass->removeInstructor($this);
        }

        return $this;
    }
    
}
