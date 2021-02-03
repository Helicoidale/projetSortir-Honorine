<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface

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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $admin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\ManyToMany(targetEntity=Outing::class, inversedBy="users")
     */
    private $outings;

    /**
     * @ORM\OneToMany(targetEntity=Outing::class, mappedBy="organisateur", orphanRemoval=true)
     */
    private $orgaOutings;

    /**
     * @ORM\ManyToOne(targetEntity=Campus::class, inversedBy="participants")
     */
    private $campus;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;




    public function __construct()
    {
        $this->outings = new ArrayCollection();
        $this->orgaOutings = new ArrayCollection();
    }

    //-------------GETTER & SETTER

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function setPassword(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection|Outing[]
     */
    public function getOutings(): Collection
    {
        return $this->outings;
    }

    public function addOuting(Outing $outing): self
    {
        if (!$this->outings->contains($outing)) {
            $this->outings[] = $outing;
        }

        return $this;
    }

    public function removeOuting(Outing $outing): self
    {
        $this->outings->removeElement($outing);

        return $this;
    }

    /**
     * @return Collection|Outing[]
     */
    public function getOrgaOutings(): Collection
    {
        return $this->orgaOutings;
    }

    public function addOrgaOuting(Outing $orgaOuting): self
    {
        if (!$this->orgaOutings->contains($orgaOuting)) {
            $this->orgaOutings[] = $orgaOuting;
            $orgaOuting->setOrganisateur($this);
        }

        return $this;
    }

    public function removeOrgaOuting(Outing $orgaOuting): self
    {
        if ($this->orgaOutings->removeElement($orgaOuting)) {
            // set the owning side to null (unless already changed)
            if ($orgaOuting->getOrganisateur() === $this) {
                $orgaOuting->setOrganisateur(null);
            }
        }

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    //----------------------------

    public function getRoles() :array
    {
       // $role=$this->role;

       // $roles[] = 'ROLE_USER';

       // return array_unique($roles);
        return ['ROLE_USER'];
    }

    /*
     * Methode plus haut
     */

    //public function getPassword()
    //{
    //   return (string) $this->motDePasse;
    //}

    public function getSalt()
    {

    }

    public function getUsername()
    {
        return $this->nom;
    }

    public function eraseCredentials()
    {

    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
}
