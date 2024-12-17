<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["debt.api.index", "debt_request.api.index"])]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    #[Groups(["debt.api.index", "debt_request.api.index"])]
    private ?string $libelle = null;

    #[ORM\Column]
    #[Groups(["debt.api.index", "debt_request.api.index"])]
    private ?int $qte_stock = null;

    /**
     * @var Collection<int, DetailDebt>
     */
    #[ORM\OneToMany(targetEntity: DetailDebt::class, mappedBy: 'article')]
    private Collection $detailDebts;

    #[ORM\Column]
    #[Groups(["debt.api.index", "debt_request.api.index"])]
    private ?int $prix = null;

    /**
     * @var Collection<int, DetailDebtRequest>
     */
    #[ORM\OneToMany(targetEntity: DetailDebtRequest::class, mappedBy: 'article')]
    private Collection $detailDebtRequests;

    public function __construct()
    {
        $this->detailDebts = new ArrayCollection();
        $this->detailDebtRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getQteStock(): ?int
    {
        return $this->qte_stock;
    }

    public function setQteStock(int $qte_stock): static
    {
        $this->qte_stock = $qte_stock;

        return $this;
    }

    /**
     * @return Collection<int, DetailDebt>
     */
    public function getDetailDebts(): Collection
    {
        return $this->detailDebts;
    }

    public function addDetailDebt(DetailDebt $detailDebt): static
    {
        if (!$this->detailDebts->contains($detailDebt)) {
            $this->detailDebts->add($detailDebt);
            $detailDebt->setArticle($this);
        }

        return $this;
    }

    public function removeDetailDebt(DetailDebt $detailDebt): static
    {
        if ($this->detailDebts->removeElement($detailDebt)) {
            // set the owning side to null (unless already changed)
            if ($detailDebt->getArticle() === $this) {
                $detailDebt->setArticle(null);
            }
        }

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

    /**
     * @return Collection<int, DetailDebtRequest>
     */
    public function getDetailDebtRequests(): Collection
    {
        return $this->detailDebtRequests;
    }

    public function addDetailDebtRequest(DetailDebtRequest $detailDebtRequest): static
    {
        if (!$this->detailDebtRequests->contains($detailDebtRequest)) {
            $this->detailDebtRequests->add($detailDebtRequest);
            $detailDebtRequest->setArticle($this);
        }

        return $this;
    }

    public function removeDetailDebtRequest(DetailDebtRequest $detailDebtRequest): static
    {
        if ($this->detailDebtRequests->removeElement($detailDebtRequest)) {
            // set the owning side to null (unless already changed)
            if ($detailDebtRequest->getArticle() === $this) {
                $detailDebtRequest->setArticle(null);
            }
        }

        return $this;
    }
}
