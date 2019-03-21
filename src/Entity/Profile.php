<?php

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 * @Serializer\ExclusionPolicy("ALL")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Expose
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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="profile", cascade={"persist", "remove"})
     */
    private $user;


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

    public function setSubscribe(?string $subscribe): self
    {
        if (!in_array($subscribe,$this->subscribe))
        {
            array_push($this->subscribe,$subscribe);
        }

        return $this;
    }

    public function getSubscribers(): ?array
    {
        return $this->subscribers;
    }

    public function setSubscribers(?string $subscribers): self
    {
        if (!in_array($subscribers,$this->subscribers)) {

            $this->subscribers[] = $subscribers;

        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function removeSubscribe(int $id): self {

        if (in_array($id,$this->subscribe)) {

            $key = array_search($id,$this->subscribe);
            unset($this->subscribe[$key]);

        }

        return $this;
    }

    public function removeSubscribers(int $id):self {

        if (in_array($id,$this->subscribers)) {

            $key = array_search($id,$this->subscribers);
            unset($this->subscribers[$key]);

        }

        return $this;
    }
}
