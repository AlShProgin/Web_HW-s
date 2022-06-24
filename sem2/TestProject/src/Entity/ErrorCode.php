<?php

namespace App\Entity;

use App\Repository\ErrorCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ErrorCodeRepository::class)]
class ErrorCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $errorDesc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getErrorDesc(): ?string
    {
        return $this->errorDesc;
    }

    public function setErrorDesc(string $errorDesc): self
    {
        $this->errorDesc = $errorDesc;

        return $this;
    }
}
