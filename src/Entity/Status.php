<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 * @ORM\Table(name="status")
 * @ORM\HasLifecycleCallbacks
 */
class Status
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $statusName;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $statusType;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\stock", inversedBy="status", cascade={"persist", "remove"})
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

    public function getId()
    {
        return $this->id;
    }

    public function getStatusName(): ?string
    {
        return $this->statusName;
    }

    public function setStatusName(?string $statusName): self
    {
        $this->statusName = $statusName;

        return $this;
    }

    public function getStatusType()
    {
        return $this->statusType;
    }

    public function setStatusType($statusType): self
    {
        $this->statusType = $statusType;

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
