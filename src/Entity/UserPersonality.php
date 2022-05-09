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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="personality_id", type="string", length=4, nullable=false)
     */
    private $personalityId;

    public function getUserPersonalityId(): ?int
    {
        return $this->userPersonalityId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPersonalityId(): ?string
    {
        return $this->personalityId;
    }

    public function setPersonalityId(string $personalityId): self
    {
        $this->personalityId = $personalityId;

        return $this;
    }


}