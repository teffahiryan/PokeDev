<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PokemonRepository::class)
 */
class Pokemon
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
     * @ORM\Column(type="string", length=255)
     */
    private $hp;

    /**
     * @ORM\ManyToMany(targetEntity=Type::class)
     */
    private $idType;

    /**
     * @ORM\ManyToMany(targetEntity=Attack::class)
     */
    private $attack;

    public function __construct()
    {
        $this->idType = new ArrayCollection();
        $this->attack = new ArrayCollection();
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

    public function getHp(): ?string
    {
        return $this->hp;
    }

    public function setHp(string $hp): self
    {
        $this->hp = $hp;

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getIdType(): Collection
    {
        return $this->idType;
    }

    public function addIdType(Type $idType): self
    {
        if (!$this->idType->contains($idType)) {
            $this->idType[] = $idType;
        }

        return $this;
    }

    public function removeIdType(Type $idType): self
    {
        $this->idType->removeElement($idType);

        return $this;
    }

    /**
     * @return Collection|Attack[]
     */
    public function getAttack(): Collection
    {
        return $this->attack;
    }

    public function addAttack(Attack $attack): self
    {
        if (!$this->attack->contains($attack)) {
            $this->attack[] = $attack;
        }

        return $this;
    }

    public function removeAttack(Attack $attack): self
    {
        $this->attack->removeElement($attack);

        return $this;
    }


}
