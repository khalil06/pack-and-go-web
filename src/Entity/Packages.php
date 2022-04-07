<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Packages
 *
 * @ORM\Table(name="packages", indexes={@ORM\Index(name="package_restaurant_fk", columns={"restaurant_id"}), @ORM\Index(name="activity_id", columns={"activity_id"}), @ORM\Index(name="package_personality_fk", columns={"personality_id"}), @ORM\Index(name="package_hotel_fk", columns={"hotel_id"})})
 * @ORM\Entity
 */
class Packages
{
    /**
     * @var int
     *
     * @ORM\Column(name="package_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $packageId;

    /**
     * @var string
     *
     * @ORM\Column(name="package_name", type="string", length=30, nullable=false)
     */
    private $packageName;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var \Activite
     *
     * @ORM\ManyToOne(targetEntity="Activite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="activity_id", referencedColumnName="id_activite")
     * })
     */
    private $activity;

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
     * @var \Hotel
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hotel_id", referencedColumnName="id_hotel")
     * })
     */
    private $hotel;

    /**
     * @var \Resteau
     *
     * @ORM\ManyToOne(targetEntity="Resteau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restaurant_id", referencedColumnName="idR")
     * })
     */
    private $restaurant;

    public function getPackageId(): ?int
    {
        return $this->packageId;
    }

    public function getPackageName(): ?string
    {
        return $this->packageName;
    }

    public function setPackageName(string $packageName): self
    {
        $this->packageName = $packageName;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getActivity(): ?Activite
    {
        return $this->activity;
    }

    public function setActivity(?Activite $activity): self
    {
        $this->activity = $activity;

        return $this;
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

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getRestaurant(): ?Resteau
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Resteau $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }


}
