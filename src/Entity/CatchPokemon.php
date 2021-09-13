<?php

namespace App\Entity;

use App\Repository\CatchPokemonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CatchPokemonRepository::class)
 */
class CatchPokemon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="catchPokemon")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class, inversedBy="catchPokemon")
     */
    private $equipeId;

    /**
     * @ORM\ManyToOne(targetEntity=Pokemon::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $pokemonId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getEquipeId(): ?Equipe
    {
        return $this->equipeId;
    }

    public function setEquipeId(?Equipe $equipeId): self
    {
        $this->equipeId = $equipeId;

        return $this;
    }

    public function getPokemonId(): ?Pokemon
    {
        return $this->pokemonId;
    }

    public function setPokemonId(?Pokemon $pokemonId): self
    {
        $this->pokemonId = $pokemonId;

        return $this;
    }
}
