<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


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
     * @Assert\NotBlank(message="nom hotel est obligatoire")
     * @Assert\NotEqualTo(0,
     *     message="doir être différent de 0")
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
     * @Assert\NotBlank(message="nombre chambres est obligatoire")
     * @Assert\NotEqualTo(0,
     *     message="doir être différent de 0")
     * @Assert\Length(
     *     max= 3,
     *     maxMessage="Nombre maximum de chambre 1000",
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Only numbers allowed"
     * )
     * @ORM\Column(name="nbr_chambres", type="integer", nullable=false)
     */
    private $nbrChambres;

    /**
     * @var string
     * @Assert\NotBlank(message="adresse hotel est obligatoire")
     * @Assert\NotEqualTo(0,
     *     message="doir être différent de 0")
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
     * @Assert\NotBlank(message="numero tel est obligatoire")
     * @Assert\NotEqualTo(0,
     *     message="doir être différent de 0")
     * @Assert\Length(
     *     max= 15,
     *     maxMessage="tel 15 chiffres"
     * )
     * @ORM\Column(name="tel", type="integer", nullable=false)
     */
    private $tel;

    /**
     * @var string
     * @Assert\NotBlank(message="email hotel obligatoire")
     * @Assert\Email(message = "L'email '{{ value }}' n est pas valide")
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="veuillez insérer une image")
     * @Assert\File(mimeTypes={ "image/jpeg" , "image/png", "image/jpg"})
     * @ORM\Column(name="image", type="string", length=200, nullable=false)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Chambre::class, mappedBy="idHotel",
     * orphanRemoval=true)
     */
    private $chambre;

    public function __construct()
    {
        $this->chambre = new ArrayCollection();
    }

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

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        if (!is_null($image)) {
            $this->image = $image;
        }
        return $this;
    }
    public function __toString() {
        return $this->getNomHotel();
    }

    /**
     * @return Collection<int, Chambre>
     */
    public function getChambre(): Collection
    {
        return $this->chambre;
    }

    public function addChambre(Chambre $chambre): self
    {
        if (!$this->chambre->contains($chambre)) {
            $this->chambre[] = $chambre;
            $chambre->setHotel($this);
        }

        return $this;
    }

    public function removeChambre(Chambre $chambre): self
    {
        if ($this->chambre->removeElement($chambre)) {
            // set the owning side to null (unless already changed)
            if ($chambre->getHotel() === $this) {
                $chambre->setHotel(null);
            }
        }

        return $this;
    }

}
