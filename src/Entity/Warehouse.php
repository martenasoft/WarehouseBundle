<?php

namespace MartenaSoft\Warehouse\Entity;

use MartenaSoft\WarehouseCommon\Entity\Traits\DescriptionTrait;
use MartenaSoft\WarehouseCommon\Entity\Traits\NameTrait;
use MartenaSoft\Warehouse\Repository\WarehouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WarehouseRepository::class)
 */
class Warehouse
{
    use NameTrait, DescriptionTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Shelving::class, mappedBy="warehouse")
     */
    private $shelving;

    public function __construct()
    {
        $this->shelving = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Shelving[]
     */
    public function getShelving(): Collection
    {
        return $this->shelving;
    }

    public function addShelving(Shelving $shelving): self
    {
        if (!$this->shelving->contains($shelving)) {
            $this->shelving[] = $shelving;
            $shelving->setWarehouse($this);
        }

        return $this;
    }

    public function removeShelving(Shelving $shelving): self
    {
        if ($this->shelving->removeElement($shelving)) {
            // set the owning side to null (unless already changed)
            if ($shelving->getWarehouse() === $this) {
                $shelving->setWarehouse(null);
            }
        }

        return $this;
    }
}
