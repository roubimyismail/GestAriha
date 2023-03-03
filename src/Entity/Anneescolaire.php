<?php

namespace App\Entity;

use App\Repository\AnneescolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnneescolaireRepository::class)]
class Anneescolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 9)]
    private ?string $annee = null;

    #[ORM\ManyToMany(targetEntity: Enseignants::class, mappedBy: 'anneescolaire')]
    private Collection $enseignants;

    public function __construct()
    {
        $this->enseignants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

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
            $enseignant->addAnneescolaire($this);
        }

        return $this;
    }

    public function removeEnseignant(Enseignants $enseignant): self
    {
        if ($this->enseignants->removeElement($enseignant)) {
            $enseignant->removeAnneescolaire($this);
        }

        return $this;
    }

    public function __toString(){
        return $this->annee;
    }
}
