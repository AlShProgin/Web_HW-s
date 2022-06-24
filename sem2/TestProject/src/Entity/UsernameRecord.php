<?php

namespace App\Entity;

use App\Repository\UsernameRecordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsernameRecordRepository::class)]
class UsernameRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private $name_entry;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'usernameRecords')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEntry(): ?string
    {
        return $this->name_entry;
    }

    public function setNameEntry(string $name_entry): self
    {
        $this->name_entry = $name_entry;

        return $this;
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
}
