<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:'i23_paniers')]
#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    private $produitQuantites = [];

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Produit::class)]
    private Collection $produits;

    #[ORM\OneToOne(mappedBy: 'panier', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:'id_user',nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    /*public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setPanier($this);
        }
        $this->produits->add($produit);
        $produit->setPanier($this);

        return $this;
    }
    */

    public function addProduit(Produit $produit, int $quantite): self
    {
        // Vérifier si le produit existe déjà dans le panier
        if (array_key_exists($produit->getId(), $this->produitQuantites)) {
            // Ajouter la quantité spécifiée à la quantité existante du produit dans le panier
            $this->produitQuantites[$produit->getId()] += $quantite;
        } else {
            // Ajouter le produit et sa quantité au panier
            $this->produits->add($produit);
            $produit->setPanier($this);
            $this->produitQuantites[$produit->getId()] = $quantite;
        }

        return $this;
    }

    /*public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getPanier() === $this) {
                $produit->setPanier(null);
            }
        }

        return $this;
    }
    */

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            // Supprimer le produit de la collection de produits du panier
            $this->produits->removeElement($produit);

            // Supprimer la quantité du produit du tableau produitQuantites
            unset($this->produitQuantites[$produit->getId()]);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getQuantity(?int $v):int
    {
        return $this->produitQuantites[$v];
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPanier(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPanier() !== $this) {
            $user->setPanier($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getTableProduitQuantites(): array
    {
        return $this->produitQuantites;
    }
}
