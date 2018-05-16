<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $enabled;

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
}
