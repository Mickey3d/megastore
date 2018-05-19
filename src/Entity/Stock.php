<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockRepository")
 * @ORM\Table(name="stock")
 * @ORM\HasLifecycleCallbacks
 */
class Stock
{
  /* CONSTANTS TO DEFINED THE STOCK AS... */
    const MAINSTOCK = 'main-stock';
    const OUTER = 'outer-stock';
    const DONATION = 'donation-stock';
    const SALED = 'saled-stock';
    const LOST = 'lost-stock';
    const BROKEN = 'broken-stock';
    const TRASH = 'trash-stock';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stockName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $stockDescription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $definedAs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Status", mappedBy="stock", cascade={"persist", "remove"})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubItem", mappedBy="stock")
     */
    private $subItems;

    public function __construct()
    {
        $this->subItems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStockName(): ?string
    {
        return $this->stockName;
    }

    public function setStockName(string $stockName): self
    {
        $this->stockName = $stockName;

        return $this;
    }

    public function getStockDescription(): ?string
    {
        return $this->stockDescription;
    }

    public function setStockDescription(?string $stockDescription): self
    {
        $this->stockDescription = $stockDescription;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
    *
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }

    public function getDefinedAs(): ?string
    {
        return $this->definedAs;
    }

    public function setDefinedAs(?string $definedAs): self
    {
        $this->definedAs = $definedAs;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        // set (or unset) the owning side of the relation if necessary
        $newStock = $status === null ? null : $this;
        if ($newStock !== $status->getStock()) {
            $status->setStock($newStock);
        }

        return $this;
    }

    /**
     * @return Collection|SubItem[]
     */
    public function getSubItems(): Collection
    {
        return $this->subItems;
    }

    public function addSubItem(SubItem $subItem): self
    {
        if (!$this->subItems->contains($subItem)) {
            $this->subItems[] = $subItem;
            $subItem->setStock($this);
        }

        return $this;
    }

    public function removeSubItem(SubItem $subItem): self
    {
        if ($this->subItems->contains($subItem)) {
            $this->subItems->removeElement($subItem);
            // set the owning side to null (unless already changed)
            if ($subItem->getStock() === $this) {
                $subItem->setStock(null);
            }
        }

        return $this;
    }
}
