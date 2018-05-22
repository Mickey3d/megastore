<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 * @ORM\Table(name="profile")
 * @ORM\HasLifecycleCallbacks
 */
class Profile
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
    private $profileName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UpdatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $restricted;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User",inversedBy="profile", cascade={"persist"} )
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="profiles" )
     * @ORM\JoinColumn(nullable=true)
     */
    private $team;


    public function getId()
    {
        return $this->id;
    }

    public function getProfileName(): ?string
    {
        return $this->profileName;
    }

    public function setProfileName(?string $profileName): self
    {
        $this->profileName = $profileName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

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

    public function getRestricted(): ?bool
    {
        return $this->restricted;
    }

    public function setRestricted(?bool $restricted): self
    {
        $this->restricted = $restricted;

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


  public function getUser(): ?User
  {
        return $this->user;
  }

  public function setUser(?User $user): self
  {
      $this->user = $user;
      return $this;
  }

  public function getTeam(): ?Team
  {
      return $this->team;
  }

  public function setTeam(?Team $team): self
  {
      $this->team = $team;
      return $this;
  }


}
