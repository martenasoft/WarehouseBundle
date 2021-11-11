<?php

namespace MartenaSoft\Warehouse\Entity;

use MartenaSoft\WarehouseCommon\Entity\Traits\DescriptionTrait;
use MartenaSoft\WarehouseCommon\Entity\Traits\NameTrait;
use MartenaSoft\Warehouse\Repository\ShelvingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShelvingRepository::class)
 */
class Shelving
{
    use NameTrait, DescriptionTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Box::class, mappedBy="shelving")
     */
    private $box;

    /**
     * @ORM\ManyToOne(targetEntity=Warehouse::class, inversedBy="shelving")
     */
    private $warehouse;

    public function __construct()
    {
        $this->box = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Box[]
     */
    public function getBox(): Collection
    {
        return $this->box;
    }

    public function addBox(Box $box): self
    {
        if (!$this->box->contains($box)) {
            $this->box[] = $box;
            $box->setShelving($this);
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        if ($this->box->removeElement($box)) {
            // set the owning side to null (unless already changed)
            if ($box->getShelving() === $this) {
                $box->setShelving(null);
            }
        }

        return $this;
    }

    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(?Warehouse $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }
}
