<?php

namespace App\Entity\Events;

use App\Entity\Location;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Events\ScheduledEventRepository")
 */
class ScheduledEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $startTime;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="scheduledEvents")
     */
    private $presenter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="scheduledEvents")
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Events\Event", inversedBy="scheduledEvents")
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPresenter(): ?User
    {
        return $this->presenter;
    }

    public function setPresenter(?User $presenter): self
    {
        $this->presenter = $presenter;

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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
