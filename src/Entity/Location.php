<?php

namespace App\Entity;

use App\Entity\Events\ScheduledEvent;
use App\Entity\Gx\ScheduledClass;
use App\Entity\Helpers\Address;
use App\Entity\Helpers\Phone;
use App\Entity\Swim\ScheduledLesson;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Helpers\Address", mappedBy="location")
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Helpers\Phone", mappedBy="location")
     */
    private $phones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Swim\ScheduledLesson", mappedBy="location")
     */
    private $scheduledLessons;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Events\ScheduledEvent", mappedBy="location")
     */
    private $scheduledEvents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gx\ScheduledClass", mappedBy="location")
     */
    private $scheduledClasses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->scheduledLessons = new ArrayCollection();
        $this->scheduledEvents = new ArrayCollection();
        $this->scheduledClasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function getFirstAddress(): string
    {
        /** @var Address $address */
        $address = $this->addresses->first();
        return $address->toString();
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setLocation($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getLocation() === $this) {
                $address->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function getFirstPhone(): string
    {
        /** @var Phone $phone */
        $phone = $this->phones->first();
        return $phone->getNumber();
    }

    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setLocation($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): self
    {
        if ($this->phones->contains($phone)) {
            $this->phones->removeElement($phone);
            // set the owning side to null (unless already changed)
            if ($phone->getLocation() === $this) {
                $phone->setLocation(null);
            }
        }

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
            $scheduledLesson->setLocation($this);
        }

        return $this;
    }

    public function removeScheduledLesson(ScheduledLesson $scheduledLesson): self
    {
        if ($this->scheduledLessons->contains($scheduledLesson)) {
            $this->scheduledLessons->removeElement($scheduledLesson);
            // set the owning side to null (unless already changed)
            if ($scheduledLesson->getLocation() === $this) {
                $scheduledLesson->setLocation(null);
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
            $scheduledEvent->setLocation($this);
        }

        return $this;
    }

    public function removeScheduledEvent(ScheduledEvent $scheduledEvent): self
    {
        if ($this->scheduledEvents->contains($scheduledEvent)) {
            $this->scheduledEvents->removeElement($scheduledEvent);
            // set the owning side to null (unless already changed)
            if ($scheduledEvent->getLocation() === $this) {
                $scheduledEvent->setLocation(null);
            }
        }

        return $this;
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
            $scheduledClass->setLocation($this);
        }

        return $this;
    }

    public function removeScheduledClass(ScheduledClass $scheduledClass): self
    {
        if ($this->scheduledClasses->contains($scheduledClass)) {
            $this->scheduledClasses->removeElement($scheduledClass);
            // set the owning side to null (unless already changed)
            if ($scheduledClass->getLocation() === $this) {
                $scheduledClass->setLocation(null);
            }
        }

        return $this;
    }
}
