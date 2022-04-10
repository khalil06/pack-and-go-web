<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservationr
 *
 * @ORM\Table(name="reservationr", indexes={@ORM\Index(name="fk_idRr", columns={"idR"}), @ORM\Index(name="fk_idUserr", columns={"id_user"})})
 * @ORM\Entity
 */
class Reservationr
{
    /**
     * @var int
     *
     * @ORM\Column(name="idreservationR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreservationr;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrPersonneR", type="integer", nullable=false)
     */
    private $nbrpersonner;

    /**
     * @var string
     *
     * @ORM\Column(name="timeR", type="string", length=30, nullable=false)
     */
    private $timer;

    /**
     * @var string
     *
     * @ORM\Column(name="dateR", type="string", length=30, nullable=false)
     */
    private $dater;

    /**
     * @var \Resteau
     *
     * @ORM\ManyToOne(targetEntity="Resteau" , inversedBy="reservationRs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idR", referencedColumnName="idR")
     * })
     */
    private $idr;
    /**
     * @ORM\OneToMany(targetEntity=Reservationr::class, mappedBy="idR")
     */
    private $reservationRs;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdreservationr(): ?int
    {
        return $this->idreservationr;
    }

    public function getRestau(): ?Resteau
    {
        return $this->restau;
    }

    public function setResteau(?Resteau $restau): self
    {
        $this->restau = $restau;

        return $this;
    }
    public function getNbrpersonner(): ?int
    {
        return $this->nbrpersonner;
    }

    public function setNbrpersonner(int $nbrpersonner): self
    {
        $this->nbrpersonner = $nbrpersonner;

        return $this;
    }

    public function getTimer(): ?string
    {
        return $this->timer;
    }

    public function setTimer(string $timer): self
    {
        $this->timer = $timer;

        return $this;
    }

    public function getDater(): ?string
    {
        return $this->dater;
    }

    public function setDater(string $dater): self
    {
        $this->dater = $dater;

        return $this;
    }

    public function getIdr(): ?Resteau
    {
        return $this->idr;
    }

    public function setIdr(?Resteau $idr): self
    {
        $this->idr = $idr;

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


}
