<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Enseignants::class, mappedBy: 'matiere')]
    private Collection $enseignants;

    public function __construct()
    {
        $this->enseignants = new ArrayCollection();
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

    /**
     * @return Collection<int, Enseignants>
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignants(Enseignants $enseignants): self
    {
        if (!$this->enseignants->contains($enseignants)) {
            $this->enseignants->add($enseignants);
            $enseignants->addMatiere($this);
        }

        return $this;
    }

    public function removeEnseignants(Enseignants $enseignants): self
    {
        if ($this->enseignants->removeElement($enseignants)) {
            $enseignants->removeMatiere($this);
        }

        return $this;
    }
    public function __toString(){
        return $this->name;
    }
}
