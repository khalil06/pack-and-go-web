<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\Mapping as ORM;

/**
 * Chambre
 * @ORM\Entity(repositoryClass="App\Repository\ChambreRepository")
 * @ORM\Table(name="chambre", indexes={@ORM\Index(name="fk_chambre_hotel", columns={"id_hotel"})})
 *
 */
class Chambre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_chambre", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idChambre;

    /**
     * @var int
     * @Assert\NotBlank(message="Numero chambre est obligatoire")
     * @Assert\NotEqualTo(0,
     *     message="doir être différent de 0")
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Only numbers allowed"
     * )
     * @ORM\Column(name="num_chambre", type="integer", nullable=false)
     */
    private $numChambre;

    /**
     * @var string
     * @Assert\NotBlank(message="Type chambre est obligatoire")
     * @Assert\NotEqualTo(0,
     *     message="doir être différent de 0")
     * @ORM\Column(name="type_chambre", type="string", length=20, nullable=false)
     */
    private $typeChambre;

    /**
     * @var int
     * @Assert\LessThan(200,
     *     message="Etage doit etre inferieur a 200")
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Only numbers allowed"
     * )
     * @Assert\NotBlank(message="Etage est obligatoire")
     * @ORM\Column(name="etage", type="integer", nullable=false)
     */
    private $etage;

    /**
     * @var int
     * @Assert\NotBlank(message="Prix est obligatoire")
     * @Assert\NotEqualTo(0,
     *     message="doir être différent de 0")
     *
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Only numbers allowed"
     * )
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var string
     * @Assert\NotBlank(message="Image est obligatoire")
     * @Assert\File(mimeTypes={ "image/jpeg" , "image/png", "image/jpg"})
     * @ORM\Column(name="image", type="string", length=100, nullable=false)
     */
    private $image;

    /**
     * @var \Hotel
     *
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="chambre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_hotel", referencedColumnName="id_hotel")
     * })
     */
    private $idHotel;

  /*  /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="chambre")
     */
   /* private $hotel;*/

    /**
     * @ORM\OneToMany(targetEntity=Reservationchambre::class, mappedBy="idChambre")
     * onDelete="CASCADE"
     */
    private $reservationCh;

    public function __construct()
    {
        $this->reservationCh = new ArrayCollection();
    }

    public function getIdChambre(): ?int
    {
        return $this->idChambre;
    }

    public function getNumChambre(): ?int
    {
        return $this->numChambre;
    }

    public function setNumChambre(int $numChambre): self
    {
        $this->numChambre = $numChambre;

        return $this;
    }

    public function getTypeChambre(): ?string
    {
        return $this->typeChambre;
    }

    public function setTypeChambre(string $typeChambre): self
    {
        $this->typeChambre = $typeChambre;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getIdHotel(): ?Hotel
    {
        return $this->idHotel;
    }

    public function setIdHotel(?Hotel $idHotel): self
    {
        $this->idHotel = $idHotel;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function __toString() {
        return (string) $this->getNumChambre();
    }

    /**
     * @return Collection<int, Reservationchambre>
     */
    public function getReservationCh(): Collection
    {
        return $this->reservationCh;
    }

    public function addReservationCh(Reservationchambre $reservationCh): self
    {
        if (!$this->reservationCh->contains($reservationCh)) {
            $this->reservationCh[] = $reservationCh;
            $reservationCh->setChambre($this);
        }

        return $this;
    }

    public function removeReservationCh(Reservationchambre $reservationCh): self
    {
        if ($this->reservationCh->removeElement($reservationCh)) {
            // set the owning side to null (unless already changed)
            if ($reservationCh->getChambre() === $this) {
                $reservationCh->setChambre(null);
            }
        }

        return $this;
    }



}
