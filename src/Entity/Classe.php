<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Eleves::class)]
    private Collection $eleves;

    #[ORM\ManyToMany(targetEntity: Enseignants::class, mappedBy: 'classe')]
    private Collection $enseignants;

    public function __construct()
    {
        $this->eleves = new ArrayCollection();
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

    

    public function __toString(){
        return $this->name;
    }

    /**
     * @return Collection<int, Eleves>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleves $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setClasse($this);
        }

        return $this;
    }

    public function removeElefe(Eleves $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasse() === $this) {
                $elefe->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Enseignants>
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignant(Enseignants $enseignant): self
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants->add($enseignant);
            $enseignant->addClasse($this);
        }

        return $this;
    }

    public function removeEnseignant(Enseignants $enseignant): self
    {
        if ($this->enseignants->removeElement($enseignant)) {
            $enseignant->removeClasse($this);
        }

        return $this;
    }
    
}
