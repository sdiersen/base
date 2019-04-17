<?php

namespace App\Entity\Events;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Events\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $shortTitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Events\ScheduledEvent", mappedBy="event")
     */
    private $scheduledEvents;

    public function __construct()
    {
        $this->scheduledEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    public function setShortTitle(?string $shortTitle): self
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

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
            $scheduledEvent->setEvent($this);
        }

        return $this;
    }

    public function removeScheduledEvent(ScheduledEvent $scheduledEvent): self
    {
        if ($this->scheduledEvents->contains($scheduledEvent)) {
            $this->scheduledEvents->removeElement($scheduledEvent);
            // set the owning side to null (unless already changed)
            if ($scheduledEvent->getEvent() === $this) {
                $scheduledEvent->setEvent(null);
            }
        }

        return $this;
    }
}
