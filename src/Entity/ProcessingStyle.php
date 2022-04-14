<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcessingStyle
 *
 * @ORM\Table(name="processing_style")
 * @ORM\Entity
 */
class ProcessingStyle
{
    /**
     * @var string
     *
     * @ORM\Column(name="processing_id", type="string", length=1, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $processingId;

    /**
     * @var string
     *
     * @ORM\Column(name="processing_name", type="string", length=20, nullable=false)
     */
    private $processingName;

    /**
     * @var string
     *
     * @ORM\Column(name="processing_details", type="text", length=65535, nullable=false)
     */
    private $processingDetails;

    public function getProcessingId(): ?string
    {
        return $this->processingId;
    }

    public function getProcessingName(): ?string
    {
        return $this->processingName;
    }

    public function setProcessingName(string $processingName): self
    {
        $this->processingName = $processingName;

        return $this;
    }

    public function getProcessingDetails(): ?string
    {
        return $this->processingDetails;
    }

    public function setProcessingDetails(string $processingDetails): self
    {
        $this->processingDetails = $processingDetails;

        return $this;
    }
    public function __toString()
    {
        return $this->processingId;
    }
}
