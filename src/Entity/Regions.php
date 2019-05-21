<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionsRepository")
 */
class Regions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Provinces", inversedBy="regions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $province;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Districts", mappedBy="region")
     */
    private $districts;

    public function __construct()
    {
        $this->districts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegion(): ?string
    {
        return strtoupper($this->region);
    }

    public function setRegion(string $region): self
    {
        $this->region = strtoupper($region);

        return $this;
    }

    public function getProvince(): ?Provinces
    {
        return $this->province;
    }

    public function setProvince(?Provinces $province): self
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return Collection|Districts[]
     */
    public function getDistricts(): Collection
    {
        return $this->districts;
    }

    public function addDistrict(Districts $district): self
    {
        if (!$this->districts->contains($district)) {
            $this->districts[] = $district;
            $district->setRegion($this);
        }

        return $this;
    }

    public function removeDistrict(Districts $district): self
    {
        if ($this->districts->contains($district)) {
            $this->districts->removeElement($district);
            // set the owning side to null (unless already changed)
            if ($district->getRegion() === $this) {
                $district->setRegion(null);
            }
        }

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
        return $this->getRegion();
    }
}
