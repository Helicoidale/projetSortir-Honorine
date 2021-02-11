<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Outing::class, mappedBy="statutEtat", orphanRemoval=true)
     */
    private $statut;

    public function __construct()
    {
        $this->statut = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Outing[]
     */
    public function getStatut(): Collection
    {
        return $this->statut;
    }

    public function addStatut(Outing $statut): self
    {
        if (!$this->statut->contains($statut)) {
            $this->statut[] = $statut;
            $statut->setStatutEtat($this);
        }

        return $this;
    }

    public function removeStatut(Outing $statut): self
    {
        if ($this->statut->removeElement($statut)) {
            // set the owning side to null (unless already changed)
            if ($statut->getStatutEtat() === $this) {
                $statut->setStatutEtat(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->libelle;
    }
}
