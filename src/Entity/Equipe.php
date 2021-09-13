<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="equipeId", cascade={"persist", "remove"})
     */
    private $trainer;

    /**
     * @ORM\OneToOne(targetEntity=Bot::class, mappedBy="equipeId", cascade={"persist", "remove"})
     */
    private $botTrainer;

    /**
     * @ORM\OneToMany(targetEntity=CatchPokemon::class, mappedBy="equipeId")
     */
    private $catchPokemon;

    public function __construct()
    {
        $this->catchPokemon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainer(): ?User
    {
        return $this->trainer;
    }

    public function setTrainer(?User $trainer): self
    {
        // unset the owning side of the relation if necessary
        if ($trainer === null && $this->trainer !== null) {
            $this->trainer->setEquipeId(null);
        }

        // set the owning side of the relation if necessary
        if ($trainer !== null && $trainer->getEquipeId() !== $this) {
            $trainer->setEquipeId($this);
        }

        $this->trainer = $trainer;

        return $this;
    }

    public function getBotTrainer(): ?Bot
    {
        return $this->botTrainer;
    }

    public function setBotTrainer(Bot $botTrainer): self
    {
        // set the owning side of the relation if necessary
        if ($botTrainer->getEquipeId() !== $this) {
            $botTrainer->setEquipeId($this);
        }

        $this->botTrainer = $botTrainer;

        return $this;
    }

    /**
     * @return Collection|CatchPokemon[]
     */
    public function getCatchPokemon(): Collection
    {
        return $this->catchPokemon;
    }

    public function addCatchPokemon(CatchPokemon $catchPokemon): self
    {
        if (!$this->catchPokemon->contains($catchPokemon)) {
            $this->catchPokemon[] = $catchPokemon;
            $catchPokemon->setEquipeId($this);
        }

        return $this;
    }

    public function removeCatchPokemon(CatchPokemon $catchPokemon): self
    {
        if ($this->catchPokemon->removeElement($catchPokemon)) {
            // set the owning side to null (unless already changed)
            if ($catchPokemon->getEquipeId() === $this) {
                $catchPokemon->setEquipeId(null);
            }
        }

        return $this;
    }

}
