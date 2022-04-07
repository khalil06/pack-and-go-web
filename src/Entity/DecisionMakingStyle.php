<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DecisionMakingStyle
 *
 * @ORM\Table(name="decision_making_style")
 * @ORM\Entity
 */
class DecisionMakingStyle
{
    /**
     * @var string
     *
     * @ORM\Column(name="decision_making_id", type="string", length=1, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $decisionMakingId;

    /**
     * @var string
     *
     * @ORM\Column(name="decision_making_name", type="string", length=20, nullable=false)
     */
    private $decisionMakingName;

    /**
     * @var string
     *
     * @ORM\Column(name="decision_making_details", type="text", length=65535, nullable=false)
     */
    private $decisionMakingDetails;

    public function getDecisionMakingId(): ?string
    {
        return $this->decisionMakingId;
    }

    public function getDecisionMakingName(): ?string
    {
        return $this->decisionMakingName;
    }

    public function setDecisionMakingName(string $decisionMakingName): self
    {
        $this->decisionMakingName = $decisionMakingName;

        return $this;
    }

    public function getDecisionMakingDetails(): ?string
    {
        return $this->decisionMakingDetails;
    }

    public function setDecisionMakingDetails(string $decisionMakingDetails): self
    {
        $this->decisionMakingDetails = $decisionMakingDetails;

        return $this;
    }


}
