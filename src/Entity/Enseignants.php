<?php

namespace App\Entity;

use App\Repository\EnseignantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantsRepository::class)]
class Enseignants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\ManyToMany(targetEntity: Matiere::class, inversedBy: 'enseignants')]
    private Collection $matiere;

    #[ORM\ManyToMany(targetEntity: Niveau::class, inversedBy: 'enseignants')]
    private Collection $niveau;

    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'enseignants')]
    private Collection $classe;

    #[ORM\ManyToMany(targetEntity: Anneescolaire::class, inversedBy: 'enseignants')]
    private Collection $anneescolaire;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->matiere = new ArrayCollection();
        $this->niveau = new ArrayCollection();
        $this->classe = new ArrayCollection();
        $this->anneescolaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, matiere>
     */
    public function getMatiere(): Collection
    {
        return $this->matiere;
    }

    public function addMatiere(Matiere $matiere): self
    {
        if (!$this->matiere->contains($matiere)) {
            $this->matiere->add($matiere);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): self
    {
        $this->matiere->removeElement($matiere);

        return $this;
    }

    /**
     * @return Collection<int, niveau>
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau->add($niveau);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        $this->niveau->removeElement($niveau);

        return $this;
    }

    /**
     * @return Collection<int, classe>
     */
    public function getClasse(): Collection
    {
        return $this->classe;
    }

    public function addClasse(Classe $classe): self
    {
        if (!$this->classe->contains($classe)) {
            $this->classe->add($classe);
        }

        return $this;
    }

    public function removeClasse(Classe $classe): self
    {
        $this->classe->removeElement($classe);

        return $this;
    }

    /**
     * @return Collection<int, anneescolaire>
     */
    public function getAnneescolaire(): Collection
    {
        return $this->anneescolaire;
    }

    public function addAnneescolaire(Anneescolaire $anneescolaire): self
    {
        if (!$this->anneescolaire->contains($anneescolaire)) {
            $this->anneescolaire->add($anneescolaire);
        }

        return $this;
    }

    public function removeAnneescolaire(Anneescolaire $anneescolaire): self
    {
        $this->anneescolaire->removeElement($anneescolaire);

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
