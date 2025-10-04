<?php
namespace App\Entity;

use App\Entity\Taille;
use App\Entity\Categorie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: "App\Repository\ProduitRepository")]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $position = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: 'float')]
    private ?float $prix = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $prixAncien = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $reduction = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: "produits")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, Taille>
     */
    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Taille::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $tailles;

    /* -------- unmapped file handling (VichUploader ou manuel) -------- */
    private ?File $imageFile = null;

    public function __construct()
    {
        $this->tailles = new ArrayCollection();
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if ($imageFile instanceof UploadedFile) {
            // permet de forcer Doctrine à voir un changement
            $this->image = null;
        }
        return $this;
    }

    /* -------------------- getters / setters -------------------- */

    public function getId(): ?int { return $this->id; }

    public function getPosition(): ?int { return $this->position; }
    public function setPosition(?int $position): self { $this->position = $position; return $this; }

    public function getNom(): ?string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(string $image): self { $this->image = $image; return $this; }

    public function getPrix(): ?float { return $this->prix; }
    public function setPrix(float $prix): self { $this->prix = $prix; return $this; }

    public function getPrixAncien(): ?float { return $this->prixAncien; }
    public function setPrixAncien(?float $prixAncien): self { $this->prixAncien = $prixAncien; return $this; }

    public function getReduction(): ?int { return $this->reduction; }
    public function setReduction(?int $reduction): self { $this->reduction = $reduction; return $this; }

    public function getCategorie(): ?Categorie { return $this->categorie; }
    public function setCategorie(?Categorie $categorie): self { $this->categorie = $categorie; return $this; }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles->add($taille);
            $taille->setProduit($this);
        }
        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->removeElement($taille)) {
            // set the owning side to null (unless already changed)
            if ($taille->getProduit() === $this) {
                $taille->setProduit(null);
            }
        }
        return $this;
    }
}