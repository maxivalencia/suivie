<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PiecesJointesRepository")
 */
class PiecesJointes
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
    private $nomFichier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomServer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referencePJ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): self
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getNomServer(): ?string
    {
        return $this->nomServer;
    }

    public function setNomServer(string $nomServer): self
    {
        $this->nomServer = $nomServer;

        return $this;
    }

    public function getReferencePJ(): ?string
    {
        return $this->referencePJ;
    }

    public function setReferencePJ(string $referencePJ): self
    {
        $this->referencePJ = $referencePJ;

        return $this;
    }
}
