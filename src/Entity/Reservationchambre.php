<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Reservationchambre
 * @ORM\Table(name="reservationchambre", indexes={@ORM\Index(name="fk_user_reservCh", columns={"id_user"}), @ORM\Index(name="fk_reserv_chambre", columns={"id_chambre"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReservationChambreRepository")
 */
class Reservationchambre
{
    /**
     * @var int
     *
     * @ORM\Column(name="num_reservation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numReservation;

    /**
     * @var \DateTime
     * @Assert\GreaterThan(
     *     value="+1 days",
     *     message="La date saisie doit être sup ou égale au {{ compared_value }}"
     * )
     * @ORM\Column(name="check_in", type="date", nullable=false)
     */
    private $checkIn;

    /**
     * @var \DateTime
     * @Assert\GreaterThan(propertyPath="checkIn",
     *     message="date check out doit etre sup a date check in")
     * @ORM\Column(name="check_out", type="date", nullable=false)
     */
    private $checkOut;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Chambre
     *
     * @ORM\ManyToOne(targetEntity=Chambre::class, inversedBy="reservationCh")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_chambre", referencedColumnName="id_chambre")
     * })
     */
    private $idChambre;

  /*  /**
     * @ORM\ManyToOne(targetEntity=Chambre::class, inversedBy="reservationCh")
     */
  /*  private $chambre;*/

    public function getNumReservation(): ?int
    {
        return $this->numReservation;
    }

    public function getCheckIn(): ?\DateTimeInterface
    {
        return $this->checkIn;
    }

    public function setCheckIn(\DateTimeInterface $checkIn): self
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    public function getCheckOut(): ?\DateTimeInterface
    {
        return $this->checkOut;
    }

    public function setCheckOut(\DateTimeInterface $checkOut): self
    {
        $this->checkOut = $checkOut;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdChambre(): ?Chambre
    {
        return $this->idChambre;
    }

    public function setIdChambre(?Chambre $idChambre): self
    {
        $this->idChambre = $idChambre;

        return $this;
    }

    public function getChambre(): ?Chambre
    {
        return $this->chambre;
    }

    public function setChambre(?Chambre $chambre): self
    {
        $this->chambre = $chambre;

        return $this;
    }

}
