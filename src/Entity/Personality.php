<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personality
 *
 * @ORM\Table(name="personality", indexes={@ORM\Index(name="decision_making_fk", columns={"decision_making"}), @ORM\Index(name="interaction_fk", columns={"interaction"}), @ORM\Index(name="processing_fk", columns={"processing"}), @ORM\Index(name="social_fk", columns={"social"})})
 * @ORM\Entity
 */
class Personality
{
    /**
     * @var string
     *
     * @ORM\Column(name="personality_id", type="string", length=4, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $personalityId;

    /**
     * @var \DecisionMakingStyle
     *
     * @ORM\ManyToOne(targetEntity="DecisionMakingStyle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="decision_making", referencedColumnName="decision_making_id")
     * })
     */
    private $decisionMaking;

    /**
     * @var \InteractionStyle
     *
     * @ORM\ManyToOne(targetEntity="InteractionStyle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="interaction", referencedColumnName="interaction_id")
     * })
     */
    private $interaction;

    /**
     * @var \ProcessingStyle
     *
     * @ORM\ManyToOne(targetEntity="ProcessingStyle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="processing", referencedColumnName="processing_id")
     * })
     */
    private $processing;

    /**
     * @var \SocialStyle
     *
     * @ORM\ManyToOne(targetEntity="SocialStyle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="social", referencedColumnName="social_id")
     * })
     */
    private $social;

    public function getPersonalityId(): ?string
    {
        return $this->personalityId;
    }

    public function getDecisionMaking(): ?DecisionMakingStyle
    {
        return $this->decisionMaking;
    }

    public function setDecisionMaking(?DecisionMakingStyle $decisionMaking): self
    {
        $this->decisionMaking = $decisionMaking;

        return $this;
    }

    public function getInteraction(): ?InteractionStyle
    {
        return $this->interaction;
    }

    public function setInteraction(?InteractionStyle $interaction): self
    {
        $this->interaction = $interaction;

        return $this;
    }

    public function getProcessing(): ?ProcessingStyle
    {
        return $this->processing;
    }

    public function setProcessing(?ProcessingStyle $processing): self
    {
        $this->processing = $processing;

        return $this;
    }

    public function getSocial(): ?SocialStyle
    {
        return $this->social;
    }

    public function setSocial(?SocialStyle $social): self
    {
        $this->social = $social;

        return $this;
    }
    public function __toString()
    {
        return $this->decisionMaking;
    }
}
