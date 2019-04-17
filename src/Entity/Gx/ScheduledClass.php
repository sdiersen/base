<?php

namespace App\Entity\Gx;

use App\Entity\Location;
use App\Entity\User;
use App\Repository\Gx\ScheduledClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Gx\ScheduledClassRepository")
 */
class ScheduledClass
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $startTime;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $endTime;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $dayOfWeek;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gx\GxClass", inversedBy="scheduledClasses")
     */
    private $gxClass;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="scheduledClasses")
     */
    private $instructor;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="scheduledClasses")
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $room;

    private static $buffaloRooms = [
        "GX1",
        "GX2",
        "POOL"
    ];

    private static $monticelloRooms = [
        "GX1",
        "GX2",
        "YOGA",
        "POOL"
    ];

    private static $zimmermanRooms = [
        "GX1",
        "POOL"
    ];

    public function __construct()
    {
        $this->instructor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(?\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(?string $dayOfWeek): self
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getGxClass(): ?GxClass
    {
        return $this->gxClass;
    }

    public function setGxClass(?GxClass $gxClass): self
    {
        $this->gxClass = $gxClass;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getInstructor(): Collection
    {
        return $this->instructor;
    }

    public function addInstructor(User $instructor): self
    {
        if (!$this->instructor->contains($instructor)) {
            $this->instructor[] = $instructor;
        }

        return $this;
    }

    public function removeInstructor(User $instructor): self
    {
        if ($this->instructor->contains($instructor)) {
            $this->instructor->removeElement($instructor);
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(?string $room): self
    {
        $this->room = $room;

        return $this;
    }

    public static function getBuffaloRooms(): array
    {
        return ScheduledClass::$buffaloRooms;
    }
    public static function getMonticelloRooms(): array
    {
        return ScheduledClass::$monticelloRooms;
    }
    public static function getZimmermanRooms(): array
    {
        return ScheduledClass::$zimmermanRooms;
    }
}
