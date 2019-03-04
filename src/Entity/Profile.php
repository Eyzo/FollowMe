<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $subscribe = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $subscribers = [];

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSubscribe(): ?array
    {
        return $this->subscribe;
    }

    public function setSubscribe(?array $subscribe): self
    {
        $this->subscribe = $subscribe;

        return $this;
    }

    public function getSubscribers(): ?array
    {
        return $this->subscribers;
    }

    public function setSubscribers(?array $subscribers): self
    {
        $this->subscribers = $subscribers;

        return $this;
    }
}
