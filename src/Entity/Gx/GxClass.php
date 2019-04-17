<?php

namespace App\Entity\Gx;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Gx\GxClassRepository")
 */
class GxClass
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $shortName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gx\ScheduledClass", mappedBy="gxClass")
     */
    private $scheduledClasses;

    public function __construct()
    {
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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): self
    {
        $this->shortName = $shortName;

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
            $scheduledClass->setGxClass($this);
        }

        return $this;
    }

    public function removeScheduledClass(ScheduledClass $scheduledClass): self
    {
        if ($this->scheduledClasses->contains($scheduledClass)) {
            $this->scheduledClasses->removeElement($scheduledClass);
            // set the owning side to null (unless already changed)
            if ($scheduledClass->getGxClass() === $this) {
                $scheduledClass->setGxClass(null);
            }
        }

        return $this;
    }

}
