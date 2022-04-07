<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPersonality
 *
 * @ORM\Table(name="user_personality", uniqueConstraints={@ORM\UniqueConstraint(name="user_id_fk", columns={"user_id"})}, indexes={@ORM\Index(name="personality_fk", columns={"personality_id"})})
 * @ORM\Entity
 */
class UserPersonality
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_personality_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userPersonalityId;

    /**
     * @var \Personality
     *
     * @ORM\ManyToOne(targetEntity="Personality")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personality_id", referencedColumnName="personality_id")
     * })
     */
    private $personality;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id_user")
     * })
     */
    private $user;

    public function getUserPersonalityId(): ?int
    {
        return $this->userPersonalityId;
    }

    public function getPersonality(): ?Personality
    {
        return $this->personality;
    }

    public function setPersonality(?Personality $personality): self
    {
        $this->personality = $personality;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
