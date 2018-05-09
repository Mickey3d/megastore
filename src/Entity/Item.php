<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 * @ORM\Table(name="item")
 * @ORM\HasLifecycleCallbacks
 */
class Item
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
    private $itemRef;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $itemName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\category")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\subCategory")
     */
    private $subCategory;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\tag")
     */
    private $tags;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $owner;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $addedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubItem", mappedBy="item")
     */
    private $subItems;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->subItems = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getItemRef(): ?string
    {
        return $this->itemRef;
    }

    public function setItemRef(string $itemRef): self
    {
        $this->itemRef = $itemRef;

        return $this;
    }

    public function getItemName(): ?string
    {
        return $this->itemName;
    }

    public function setItemName(string $itemName): self
    {
        $this->itemName = $itemName;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ?subCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?subCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection|tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

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

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    public function setAddedAt(?\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

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
            $subItem->setItem($this);
        }

        return $this;
    }

    public function removeSubItem(SubItem $subItem): self
    {
        if ($this->subItems->contains($subItem)) {
            $this->subItems->removeElement($subItem);
            // set the owning side to null (unless already changed)
            if ($subItem->getItem() === $this) {
                $subItem->setItem(null);
            }
        }

        return $this;
    }
}
