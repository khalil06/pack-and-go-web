<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="fk_idUser", columns={"id_user"}), @ORM\Index(name="fk_idR", columns={"idR"})})
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
     *
     * @ORM\Column(name="contenuCommentaireR", type="string", length=100, nullable=false)
     */
    private $contenucommentairer;

    /**
     * @var \Resteau
     *
     * @ORM\ManyToOne(targetEntity="Resteau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idR", referencedColumnName="idR")
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

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
