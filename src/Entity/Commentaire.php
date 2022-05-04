<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="fk_idR", columns={"idR"}), @ORM\Index(name="fk_idUser", columns={"id_user"})})
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCommentaireR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcommentairer;

    /**
     * @var string
     * @Assert\NotBlank(message="commentaire tel est obligatoire")
     * @ORM\Column(name="contenuCommentaireR", type="string", length=100, nullable=false)
     */
    private $contenucommentairer;

    /**
     * @var \Resteau
     *
     * @ORM\ManyToOne(targetEntity="Resteau",inversedBy="Commentaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idR", referencedColumnName="idR",onDelete="CASCADE")
     * })
     */
    private $idr;



    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdcommentairer(): ?int
    {
        return $this->idcommentairer;
    }

    public function getContenucommentairer(): ?string
    {
        return $this->contenucommentairer;
    }

    public function setContenucommentairer(string $contenucommentairer): self
    {
        $this->contenucommentairer = $contenucommentairer;

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
    public function  __toString()
    {
        return (String) $this ->getFirstName();
    }


    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
    public function getResteau(): ?Resteau
    {
        return $this->Resteau;
    }

    public function setResteau(?Resteau $resteau): self
    {
        $this->Resteau = $resteau;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
