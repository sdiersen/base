<?php

namespace App\Entity\Helpers;

use App\Entity\Location;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Helpers\PhoneRepository")
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="phones")
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

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
}
