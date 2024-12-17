<?php

namespace App\Entity;

use App\Repository\DetailDebtRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DetailDebtRequestRepository::class)]
class DetailDebtRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["debt_request.api.index"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'detailDebtRequests')]
    #[Groups(["debt_request.api.index"])]

    private ?Article $article = null;

    #[ORM\ManyToOne(inversedBy: 'detailDebtRequests')]
    private ?DebtRequest $DebtRequest = null;

    #[ORM\Column]
    #[Groups(["debt_request.api.index"])]

    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(["debt_request.api.index"])]

    private ?int $prix = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDebtRequest(): ?DebtRequest
    {
        return $this->DebtRequest;
    }

    public function setDebtRequest(?DebtRequest $DebtRequest): static
    {
        $this->DebtRequest = $DebtRequest;

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
