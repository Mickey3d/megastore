<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, \Serializable
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
    private $username;

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
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

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
    private $enabled;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $restricted;

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
      $roles = $this->roles;

      // To be sure we have at less One Role
      if (empty($roles)) {
          $roles[] = 'ROLE_USER';
      }

      return array_unique($roles);
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

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
    * Give back the salt which serve to encode the password
    *
    * {@inheritdoc}
    */
    public function getSalt(): ?string
    {
    // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
    // we're using bcrypt in security.yml to encode the password, so
    // the salt value is built-in and you don't have to generate one

    return null;
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
  * Removes sensitive data from the user.
  *
  * {@inheritdoc}
  */
  public function eraseCredentials(): void
  {
    // We don't need thos method beacuase we don't use plainPassword
    // But it is madatory because implemented in the interface of UserInterface
    // $this->plainPassword = null;
  }

  /**
  * {@inheritdoc}
  */
  public function serialize(): string
  {
      return serialize([$this->id, $this->username, $this->password]);
  }

  /**
  * {@inheritdoc}
  */
  public function unserialize($serialized): void
  {
      [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
  }
}
