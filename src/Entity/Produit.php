<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name:'i23_produits')]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING,length: 12,nullable: false)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::FLOAT,nullable: false)]
    private ?float $prix = null;

    #[ORM\Column(type: Types::INTEGER,nullable: false)]
    private ?int $enstock = null;

    public function __construct()
    {

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEnstock(): ?int
    {
        return $this->enstock;
    }

    public function setEnstock(int $enstock): self
    {
        $this->enstock = $enstock;

        return $this;
    }
}
