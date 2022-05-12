<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $class;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $final_price;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Vol::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vol;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getFinalPrice(): ?float
    {
        return $this->final_price;
    }

    public function setFinalPrice(float $final_price): self
    {
        $this->final_price = $final_price;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getVol(): ?Vol
    {
        return $this->vol;
    }

    public function setVol(?Vol $vol): self
    {
        $this->vol = $vol;

        return $this;
    }
    public function __toString()
    {
        return $this->client;
    }
}
