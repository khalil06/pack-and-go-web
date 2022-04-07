<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InteractionStyle
 *
 * @ORM\Table(name="interaction_style")
 * @ORM\Entity
 */
class InteractionStyle
{
    /**
     * @var string
     *
     * @ORM\Column(name="interaction_id", type="string", length=1, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $interactionId;

    /**
     * @var string
     *
     * @ORM\Column(name="interaction_name", type="string", length=20, nullable=false)
     */
    private $interactionName;

    /**
     * @var string
     *
     * @ORM\Column(name="interaction_details", type="text", length=65535, nullable=false)
     */
    private $interactionDetails;

    public function getInteractionId(): ?string
    {
        return $this->interactionId;
    }

    public function getInteractionName(): ?string
    {
        return $this->interactionName;
    }

    public function setInteractionName(string $interactionName): self
    {
        $this->interactionName = $interactionName;

        return $this;
    }

    public function getInteractionDetails(): ?string
    {
        return $this->interactionDetails;
    }

    public function setInteractionDetails(string $interactionDetails): self
    {
        $this->interactionDetails = $interactionDetails;

        return $this;
    }


}
