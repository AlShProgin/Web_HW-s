<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'chat', targetEntity: UserChatList::class, orphanRemoval: true)]
    private $users;
    
    #[ORM\OneToMany(mappedBy: 'chat_id', targetEntity: Message::class, orphanRemoval: true)]
    private $messages;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, UserChatList>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UserChatList $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setChat($this);
        }

        return $this;
    }

    public function removeUser(UserChatList $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getChat() === $this) {
                $user->setChat(null);
            }
        }

        return $this;
    }
}
