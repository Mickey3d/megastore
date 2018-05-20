<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Stock;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubItemRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SubItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subItemRef;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item", inversedBy="subItems")
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status")
     * @ORM\JoinColumn(nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $owner;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stock", inversedBy="subItems")
     */
    private $stock;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inStore;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $reserved;

    public function getId()
    {
        return $this->id;
    }

    public function getSubItemRef(): ?string
    {
        return $this->subItemRef;
    }

    public function setSubItemRef(?string $subItemRef): self
    {
        $this->subItemRef = $subItemRef;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getStatus(): ?status
    {
        return $this->status;
    }

    public function setStatus(?status $status): self
    {
        $this->status = $status;

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

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(?string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getStock(): ?stock
    {
        return $this->stock;
    }

    public function setStock(?stock $stock): self
    {
        $this->stock = $stock;

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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getInStore(): ?bool
    {
        return $this->inStore;
    }

    public function setInStore(?bool $inStore): self
    {
        $this->inStore = $inStore;

        return $this;
    }

    public function getReserved(): ?bool
    {
        return $this->reserved;
    }

    public function setReserved(?bool $reserved): self
    {
        $this->reserved = $reserved;

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

    /**
    *
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function subItemManager()
    {
        $selfStock = $this->getStock();
        $selfStatus = $this->getStatus();

        if ($selfStock == null AND $selfStatus == null) {
          $this->inStore = false;
          $this->enabled = false;
        }

        if ($selfStock != null AND $selfStatus == null) {
          $selfStockDefinedAs = $selfStock->getDefinedAs();
          if($selfStockDefinedAs == Stock::MAINSTOCK)
          {
              $this->inStore = true;
              $this->enabled = true;
          }
          else {
            $this->inStore = false;
          }
          if($selfStockDefinedAs == Stock::OUTER)
          {
              $this->enabled = true;
          }
          if ($selfStockDefinedAs == Stock::DONATION | $selfStockDefinedAs == Stock::SALED | $selfStockDefinedAs == Stock::LOST | $selfStockDefinedAs == Stock::BROKEN | $selfStockDefinedAs == Stock::TRASH ) {
            $this->enabled = false;
         }
        }

        if ($selfStock == null AND $selfStatus != null) {
          $statusStock = $selfStatus->getStock();
          if ($statusStock != null) {
            $this->setStock($statusStock);
            $statusStockDefinedAs = $statusStock->getDefinedAs();
            if($statusStock->getDefinedAs() == Stock::MAINSTOCK)
            {
                $this->inStore = true;
                $this->enabled = true;
            }
            else {
              $this->inStore = false;
            }
            if ($statusStockDefinedAs == Stock::OUTER) {
              $this->enabled = true;
            }
            if ($statusStockDefinedAs == Stock::DONATION | $statusStockDefinedAs == Stock::SALED | $statusStockDefinedAs == Stock::LOST | $statusStockDefinedAs == Stock::BROKEN | $statusStockDefinedAs == Stock::TRASH ) {
              $this->enabled = false;
            }
          }
        }

        if ($selfStock != null AND $selfStatus != null) {
          $statusStock = $selfStatus->getStock();
          if ($statusStock != null) {
            $this->setStock($statusStock);
            $statusStockDefinedAs = $statusStock->getDefinedAs();
            if ($statusStockDefinedAs == Stock::MAINSTOCK) {
              $this->inStore = true;
              $this->enabled = true;
            }
            else {
              $this->inStore = false;
            }
            if ($statusStockDefinedAs == Stock::OUTER) {
              $this->enabled = true;
            }
            if ($statusStockDefinedAs == Stock::DONATION | $statusStockDefinedAs == Stock::SALED | $statusStockDefinedAs == Stock::LOST | $statusStockDefinedAs == Stock::BROKEN | $statusStockDefinedAs == Stock::TRASH ) {
              $this->enabled = false;
            }
         }
       }
    }

}
