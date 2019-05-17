<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossiersRepository")
 */
class Dossiers
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
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objet;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateexpedition;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $daterecepnumeric;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $daterecepeffectif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referencesuivie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dureetraitement;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dureeeffectif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $suggestions;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $piecejointes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Resultats", inversedBy="dossiers")
     */
    private $resultat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeDossiers", inversedBy="dossiers")
     */
    private $typedossier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Traitements", inversedBy="dossiers")
     */
    private $traitement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unites", inversedBy="dossiers")
     */
    private $uniteorigine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Unites", inversedBy="dossiers")
     */
    private $unitedestinataire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dossiers", inversedBy="dossiers")
     */
    private $precdossiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dossiers", mappedBy="precdossiers")
     */
    private $dossiers;

    public function __construct()
    {
        $this->dossiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getDateexpedition(): ?\DateTimeInterface
    {
        return $this->dateexpedition;
    }

    public function setDateexpedition(\DateTimeInterface $dateexpedition): self
    {
        $this->dateexpedition = $dateexpedition;

        return $this;
    }

    public function getDaterecepnumeric(): ?\DateTimeInterface
    {
        return $this->daterecepnumeric;
    }

    public function setDaterecepnumeric(?\DateTimeInterface $daterecepnumeric): self
    {
        $this->daterecepnumeric = $daterecepnumeric;

        return $this;
    }

    public function getDaterecepeffectif(): ?\DateTimeInterface
    {
        return $this->daterecepeffectif;
    }

    public function setDaterecepeffectif(?\DateTimeInterface $daterecepeffectif): self
    {
        $this->daterecepeffectif = $daterecepeffectif;

        return $this;
    }

    public function getReferencesuivie(): ?string
    {
        return $this->referencesuivie;
    }

    public function setReferencesuivie(string $referencesuivie): self
    {
        $this->referencesuivie = $referencesuivie;

        return $this;
    }

    public function getDureetraitement(): ?int
    {
        return $this->dureetraitement;
    }

    public function setDureetraitement(?int $dureetraitement): self
    {
        $this->dureetraitement = $dureetraitement;

        return $this;
    }

    public function getDureeeffectif(): ?int
    {
        return $this->dureeeffectif;
    }

    public function setDureeeffectif(?int $dureeeffectif): self
    {
        $this->dureeeffectif = $dureeeffectif;

        return $this;
    }

    public function getSuggestions(): ?string
    {
        return $this->suggestions;
    }

    public function setSuggestions(?string $suggestions): self
    {
        $this->suggestions = $suggestions;

        return $this;
    }

    public function getPiecejointes(): ?string
    {
        return $this->piecejointes;
    }

    public function setPiecejointes(?string $piecejointes): self
    {
        $this->piecejointes = $piecejointes;

        return $this;
    }

    public function getResultat(): ?Resultats
    {
        return $this->resultat;
    }

    public function setResultat(?Resultats $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getTypedossier(): ?TypeDossiers
    {
        return $this->typedossier;
    }

    public function setTypedossier(?TypeDossiers $typedossier): self
    {
        $this->typedossier = $typedossier;

        return $this;
    }

    public function getTraitement(): ?Traitements
    {
        return $this->traitement;
    }

    public function setTraitement(?Traitements $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }

    public function getUniteorigine(): ?Unites
    {
        return $this->uniteorigine;
    }

    public function setUniteorigine(?Unites $uniteorigine): self
    {
        $this->uniteorigine = $uniteorigine;

        return $this;
    }

    public function getUnitedestinataire(): ?Unites
    {
        return $this->unitedestinataire;
    }

    public function setUnitedestinataire(?Unites $unitedestinataire): self
    {
        $this->unitedestinataire = $unitedestinataire;

        return $this;
    }

    public function getPrecdossiers(): ?self
    {
        return $this->precdossiers;
    }

    public function setPrecdossiers(?self $precdossiers): self
    {
        $this->precdossiers = $precdossiers;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(self $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setPrecdossiers($this);
        }

        return $this;
    }

    public function removeDossier(self $dossier): self
    {
        if ($this->dossiers->contains($dossier)) {
            $this->dossiers->removeElement($dossier);
            // set the owning side to null (unless already changed)
            if ($dossier->getPrecdossiers() === $this) {
                $dossier->setPrecdossiers(null);
            }
        }

        return $this;
    }
}
