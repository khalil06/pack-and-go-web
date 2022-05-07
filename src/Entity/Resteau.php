<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Serializer\Annotation\Groups;
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
     * @Groups("Resteau")

     */
    private $typer;

    /**
     * @var string
     * @Assert\NotBlank(message="nom Restau est obligatoire")
     * @ORM\Column(name="nomR", type="string", length=30, nullable=false)
     * @Groups("Resteau")
     */
    private $nomr;

    /**
     * @var string
     * @Assert\NotBlank(message="adresse Restau est obligatoire")
     * @ORM\Column(name="adressR", type="string", length=30, nullable=false)
     * @Groups("Resteau")

     */
    private $adressr;

    /**
     * @var string
     * @Assert\NotBlank(message="pays est obligatoire")
     * @ORM\Column(name="paysR", type="string", length=30, nullable=false)
     * @Groups("Resteau")

     */
    private $paysr;

    /**
     * @var string
     * @Assert\NotBlank(message="numero tel est obligatoire")
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Only numbers allowed"
     * )
     * @ORM\Column(name="telR", type="string", length=30, nullable=false)
     * @Groups("Resteau")

     */
    private $telr;

    /**
     * @var string
     * @Assert\NotBlank(message="veuillez insérer une image")
     * @Assert\File(mimeTypes={ "image/jpeg" , "image/png", "image/jpg"})
     * @Assert\NotBlank(message="veuillez insérer une image")
     * @ORM\Column(name="imgR", type="string", length=50, nullable=false)
     * @Groups("Resteau")

     */
    private $imgr;

    /**
     * @var int
     *
     * @ORM\Column(name="idR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY" )
     * @Groups("Resteau")
     */
    private $idr;

    /**
     * @ORM\OneToMany(targetEntity=Reservationr::class, mappedBy="idr" ,cascade={"remove"})
     */
    private $reservationRs;
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="idr",cascade={"remove"})
     */
    private $commentaires;
    public function __construct()
    {
        $this->reservationRs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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
    public function setImgr(string $imgr): self
    {
        if (!is_null($imgr)) {
            $this->imgr = $imgr;
        }
        return $this;
    }
    public function getImgr(): ?string
    {
        return $this->imgr;
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

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setIdR($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdR() === $this) {
                $commentaire->setIdR(null);
            }
        }

        return $this;
    }
    public function  __toString()
    {
        return (String) $this->getIdr() ;


    }


}