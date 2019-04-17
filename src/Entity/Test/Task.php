<?php

namespace App\Entity\Test;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Test\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $task;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\Type("\DateTime")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Assert\Choice(
     *     choices = { "hi", "low", "no" },
     *     message = "Choose a valid priority."
     * )
     */
    private $priority;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function getDueDateAsString(): ?string
    {
        return date_format($this->dueDate, 'm/d/Y');
    }

    public function setDueDate(?\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
