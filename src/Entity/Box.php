<?php

namespace MartenaSoft\Warehouse\Entity;

use MartenaSoft\WarehouseCommon\Entity\Traits\DescriptionTrait;
use MartenaSoft\WarehouseCommon\Entity\Traits\NameTrait;
use MartenaSoft\Warehouse\Repository\BoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use MartenaSoft\WarehouseProduct\Entity\Product;

/**
 * @ORM\Entity(repositoryClass=BoxRepository::class)
 */
class Box
{
    use NameTrait, DescriptionTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Shelving::class, inversedBy="box")
     */
    private $shelving;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="box")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShelving(): ?Shelving
    {
        return $this->shelving;
    }

    public function setShelving(?Shelving $shelving): self
    {
        $this->shelving = $shelving;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setBox($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBox() === $this) {
                $product->setBox(null);
            }
        }

        return $this;
    }
}
