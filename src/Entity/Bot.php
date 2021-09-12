<?php

namespace App\Entity;

use App\Repository\BotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BotRepository::class)
 */
class Bot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Equipe::class, inversedBy="botTrainer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipeId;

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

    public function getEquipeId(): ?Equipe
    {
        return $this->equipeId;
    }

    public function setEquipeId(Equipe $equipeId): self
    {
        $this->equipeId = $equipeId;

        return $this;
    }
}
