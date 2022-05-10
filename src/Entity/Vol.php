<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VolRepository::class)
 */
class Vol
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
    private $origin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $destination;

    private $today;

    public function getToday(): ?\DateTimeInterface
    {
        return $this->today;
    }

    /**
     * @ORM\Column(type="datetime")
     *
     * @Assert\Expression ("this.getDepartureDate()> this.getToday() ")
     */
    private $departure_date;


    /**
     * @ORM\Column(type="datetime")
     * @Assert\Expression("this.getArrivalDate()>this.getDepartureDate() ")
     */
    private $arrival_date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     */
    private $initial_price;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="vols")
     * @ORM\JoinColumn(nullable=false)
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="vol", orphanRemoval=true)
     */
    private $reservations;

    public function __construct()
    {
        $this->today =new \DateTime();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departure_date;
    }

    public function setDepartureDate(\DateTimeInterface $departure_date): self
    {
        $this->departure_date = $departure_date;

        return $this;
    }


    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrival_date;
    }

    public function setArrivalDate(\DateTimeInterface $arrival_date): self
    {
        $this->arrival_date = $arrival_date;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getInitialPrice(): ?float
    {
        return $this->initial_price;
    }

    public function setInitialPrice(float $initial_price): self
    {
        $this->initial_price = $initial_price;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setVol($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVol() === $this) {
                $reservation->setVol(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->destination;
    }
}
