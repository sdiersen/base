<?php

namespace App\Entity\Helpers;

use App\Entity\Location;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Helpers\AddressRepository")
 */
class Address
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetTwo;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $route;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="addresses")
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

    public function getStreetOne(): ?string
    {
        return $this->streetOne;
    }

    public function setStreetOne(?string $streetOne): self
    {
        $this->streetOne = $streetOne;

        return $this;
    }

    public function getStreetTwo(): ?string
    {
        return $this->streetTwo;
    }

    public function setStreetTwo(?string $streetTwo): self
    {
        $this->streetTwo = $streetTwo;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(?string $route): self
    {
        $this->route = $route;

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

    public function toString(): string
    {
        return $this->streetOne . ", " . $this->city . " " . $this->state . " " . $this->zip;
    }
}
