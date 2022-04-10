<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Resteau
 *
 * @ORM\Table(name="resteau")
 * @ORM\Entity
 */
class Resteau
{
    /**
     * @var string
     *
     * @ORM\Column(name="typeR", type="string", length=30, nullable=false)
     */
    private $typer;

    /**
     * @var string
     *
     * @ORM\Column(name="nomR", type="string", length=30, nullable=false)
     */
    private $nomr;

    /**
     * @var string
     *
     * @ORM\Column(name="adressR", type="string", length=30, nullable=false)
     */
    private $adressr;

    /**
     * @var string
     *
     * @ORM\Column(name="paysR", type="string", length=30, nullable=false)
     */
    private $paysr;

    /**
     * @var string
     *
     * @ORM\Column(name="telR", type="string", length=30, nullable=false)
     */
    private $telr;

    /**
     * @var string
     *
     * @ORM\Column(name="imgR", type="string", length=50, nullable=false)
     */
    private $imgr;

    /**
     * @var int
     *
     * @ORM\Column(name="idR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idr;

    /**
     * @ORM\OneToMany(targetEntity=Reservationr::class, mappedBy="idR")
     */
    private $reservationRs;

    public function __construct()
    {
        $this->reservationRs = new ArrayCollection();
    }

    public function getTyper(): ?string
    {
        return $this->typer;
    }

    public function setTyper(string $typer): self
    {
        $this->typer = $typer;

        return $this;
    }

    public function getNomr(): ?string
    {
        return $this->nomr;
    }

    public function setNomr(string $nomr): self
    {
        $this->nomr = $nomr;

        return $this;
    }

    public function getAdressr(): ?string
    {
        return $this->adressr;
    }

    public function setAdressr(string $adressr): self
    {
        $this->adressr = $adressr;

        return $this;
    }

    public function getPaysr(): ?string
    {
        return $this->paysr;
    }

    public function setPaysr(string $paysr): self
    {
        $this->paysr = $paysr;

        return $this;
    }

    public function getTelr(): ?string
    {
        return $this->telr;
    }

    public function setTelr(string $telr): self
    {
        $this->telr = $telr;

        return $this;
    }

    public function getImgr(): ?string
    {
        return $this->imgr;
    }

    public function setImgr(string $imgr): self
    {
        $this->imgr = $imgr;

        return $this;
    }

    public function getIdr(): ?int
    {
        return $this->idr;
    }
    /**
     * @return Collection<int, Reservationr>
     */
    public function getReservationRs(): Collection
    {
        return $this->reservationRs;
    }

    public function addReservationR(Reservationr $reservationR): self
    {
        if (!$this->reservationRs->contains($reservationR)) {
            $this->reservationRs[] = $reservationR;
            $reservationR->setIdR($this);
        }

        return $this;
    }

    public function removeReservationR(Reservationr $reservationR): self
    {
        if ($this->reservationRs->removeElement($reservationR)) {
            // set the owning side to null (unless already changed)
            if ($reservationR->getIdR() === $this) {
                $reservationR->setIdR(null);
            }
        }

        return $this;
    }


}
