<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialStyle
 *
 * @ORM\Table(name="social_style")
 * @ORM\Entity
 */
class SocialStyle
{
    /**
     * @var string
     *
     * @ORM\Column(name="social_id", type="string", length=1, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $socialId;

    /**
     * @var string
     *
     * @ORM\Column(name="social_name", type="string", length=20, nullable=false)
     */
    private $socialName;

    /**
     * @var string
     *
     * @ORM\Column(name="social_details", type="text", length=65535, nullable=false)
     */
    private $socialDetails;

    public function getSocialId(): ?string
    {
        return $this->socialId;
    }

    public function getSocialName(): ?string
    {
        return $this->socialName;
    }

    public function setSocialName(string $socialName): self
    {
        $this->socialName = $socialName;

        return $this;
    }

    public function getSocialDetails(): ?string
    {
        return $this->socialDetails;
    }

    public function setSocialDetails(string $socialDetails): self
    {
        $this->socialDetails = $socialDetails;

        return $this;
    }
    public function __toString()
    {
        return $this->socialId;
    }
}
