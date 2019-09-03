<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UnitesRepository")
 */
class Unites
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unite;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $abreviation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Communes", inversedBy="unites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commune;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unites", inversedBy="unites")
     */
    private $unitesuperieur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Unites", mappedBy="unitesuperieur")
     */
    private $unites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dossiers", mappedBy="uniteorigine")
     */
    private $dossiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="unite")
     */
    private $users;

    public function __construct()
    {
        $this->unites = new ArrayCollection();
        $this->dossiers = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnite(): ?string
    {
        return strtoupper($this->unite);
    }

    public function setUnite(string $unite): self
    {
        $this->unite = strtoupper($unite);

        return $this;
    }

    public function getAbreviation(): ?string
    {
        return strtoupper($this->abreviation);
    }

    public function setAbreviation(string $abreviation): self
    {
        $this->abreviation = strtoupper($abreviation);

        return $this;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(string $localite): self
    {
        $this->localite = $localite;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCommune(): ?Communes
    {
        return $this->commune;
    }

    public function setCommune(?Communes $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    public function getUnitesuperieur(): ?self
    {
        return $this->unitesuperieur;
    }

    public function setUnitesuperieur(?self $unitesuperieur): self
    {
        $this->unitesuperieur = $unitesuperieur;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUnites(): Collection
    {
        return $this->unites;
    }

    public function addUnite(self $unite): self
    {
        if (!$this->unites->contains($unite)) {
            $this->unites[] = $unite;
            $unite->setUnitesuperieur($this);
        }

        return $this;
    }

    public function removeUnite(self $unite): self
    {
        if ($this->unites->contains($unite)) {
            $this->unites->removeElement($unite);
            // set the owning side to null (unless already changed)
            if ($unite->getUnitesuperieur() === $this) {
                $unite->setUnitesuperieur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dossiers[]
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossiers $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setUniteorigine($this);
        }

        return $this;
    }

    public function removeDossier(Dossiers $dossier): self
    {
        if ($this->dossiers->contains($dossier)) {
            $this->dossiers->removeElement($dossier);
            // set the owning side to null (unless already changed)
            if ($dossier->getUniteorigine() === $this) {
                $dossier->setUniteorigine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUnite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUnite() === $this) {
                $user->setUnite(null);
            }
        }

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
        return $this->getUnite();
    }
}
