<?php

namespace App\Entity;

use App\Repository\DetailDebtRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DetailDebtRepository::class)]
class DetailDebt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["debt.api.index"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detailDebts')]
    private ?Debt $debt = null;

    #[ORM\ManyToOne(inversedBy: 'detailDebts')]
    #[Groups(["debt.api.index"])]
    private ?Article $article = null;

    #[ORM\Column]
    #[Groups(["debt.api.index"])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(["debt.api.index"])]
    private ?int $prix = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDebt(): ?Debt
    {
        return $this->debt;
    }

    public function setDebt(?Debt $debt): static
    {
        $this->debt = $debt;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }
}
