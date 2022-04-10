<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hotel
 *
 * @ORM\Table(name="hotel")
 * @ORM\Entity
 */
class Hotel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_hotel", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idHotel;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_hotel", type="string", length=30, nullable=false)
     */
    private $nomHotel;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_etoiles", type="integer", nullable=false)
     */
    private $nbrEtoiles;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_chambres", type="integer", nullable=false)
     */
    private $nbrChambres;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=50, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=30, nullable=false)
     */
    private $pays;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer", nullable=false)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=200, nullable=false)
     */
    private $image;

    public function getIdHotel(): ?int
    {
        return $this->idHotel;
    }

    public function getNomHotel(): ?string
    {
        return $this->nomHotel;
    }

    public function setNomHotel(string $nomHotel): self
    {
        $this->nomHotel = $nomHotel;

        return $this;
    }

    public function getNbrEtoiles(): ?int
    {
        return $this->nbrEtoiles;
    }

    public function setNbrEtoiles(int $nbrEtoiles): self
    {
        $this->nbrEtoiles = $nbrEtoiles;

        return $this;
    }

    public function getNbrChambres(): ?int
    {
        return $this->nbrChambres;
    }

    public function setNbrChambres(int $nbrChambres): self
    {
        $this->nbrChambres = $nbrChambres;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }


}
