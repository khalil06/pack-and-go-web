<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservationchambre
 *
 * @ORM\Table(name="reservationchambre", indexes={@ORM\Index(name="fk_user_reservCh", columns={"id_user"}), @ORM\Index(name="fk_reserv_chambre", columns={"id_chambre"})})
 * @ORM\Entity
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
     *
     * @ORM\Column(name="check_in", type="date", nullable=false)
     */
    private $checkIn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="check_out", type="date", nullable=false)
     */
    private $checkOut;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_chambre", type="integer", nullable=false)
     */
    private $idChambre;

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

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdChambre(): ?int
    {
        return $this->idChambre;
    }

    public function setIdChambre(int $idChambre): self
    {
        $this->idChambre = $idChambre;

        return $this;
    }

}
