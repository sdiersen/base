<?php

namespace App\Entity\Swim;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Swim\LessonRepository")
 */
class Lesson
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $requirements;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Swim\ScheduledLesson", mappedBy="lesson")
     */
    private $scheduledLessons;

    public function __construct()
    {
        $this->scheduledLessons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getRequirements(): ?string
    {
        return $this->requirements;
    }

    public function setRequirements(?string $requirements): self
    {
        $this->requirements = $requirements;

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
            $scheduledLesson->setLesson($this);
        }

        return $this;
    }

    public function removeScheduledLesson(ScheduledLesson $scheduledLesson): self
    {
        if ($this->scheduledLessons->contains($scheduledLesson)) {
            $this->scheduledLessons->removeElement($scheduledLesson);
            // set the owning side to null (unless already changed)
            if ($scheduledLesson->getLesson() === $this) {
                $scheduledLesson->setLesson(null);
            }
        }

        return $this;
    }
}
