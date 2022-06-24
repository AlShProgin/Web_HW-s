<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
/**
 * @Entity
 * @Table(name="user",uniqueConstraints={@UniqueConstraint(name="name_idx_unq", columns={"name"})})
 */
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private $name;
    
    #[ORM\Column(type: 'string', length: 40)]
    private $password;

    #[ORM\OneToMany(mappedBy: 'name', targetEntity: Message::class, orphanRemoval: true)]
    private $messages;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserChatList::class, orphanRemoval: true)]
    private $chats;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UsernameRecord::class, orphanRemoval: true)]
    private $usernameRecords;

    #[ORM\Column(type: 'string', length: 40)]

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        #$this->content = new ArrayCollection();
        $this->chats = new ArrayCollection();
        $this->usernameRecords = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setName($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getName() === $this) {
                $message->setName(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserChatList>
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(UserChatList $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setUsers($this);
        }

        return $this;
    }

    public function removeChat(UserChatList $chat): self
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getUsers() === $this) {
                $chat->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UsernameRecord>
     */
    public function getUsernameRecords(): Collection
    {
        return $this->usernameRecords;
    }

    public function addUsernameRecord(UsernameRecord $usernameRecord): self
    {
        if (!$this->usernameRecords->contains($usernameRecord)) {
            $this->usernameRecords[] = $usernameRecord;
            $usernameRecord->setUser($this);
        }

        return $this;
    }

    public function removeUsernameRecord(UsernameRecord $usernameRecord): self
    {
        if ($this->usernameRecords->removeElement($usernameRecord)) {
            // set the owning side to null (unless already changed)
            if ($usernameRecord->getUser() === $this) {
                $usernameRecord->setUser(null);
            }
        }

        return $this;
    }
}
