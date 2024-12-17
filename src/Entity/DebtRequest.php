<?php

namespace App\Entity;

use App\Repository\DebtRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DebtRequestRepository::class)]
#[Groups(["debt_request.api.index"])]
class DebtRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $total_amount = null;

    #[ORM\ManyToOne(inversedBy: 'debtRequests')]
    private ?Client $client = null;

    /**
     * @var Collection<int, DetailDebtRequest>
     */
    #[ORM\OneToMany(targetEntity: DetailDebtRequest::class, mappedBy: 'DebtRequest')]
    private Collection $detailDebtRequests;

    public function __construct()
    {
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalAmount(): ?int
    {
        return $this->total_amount;
    }

    public function setTotalAmount(int $total_amount): static
    {
        $this->total_amount = $total_amount;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

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
            $detailDebtRequest->setDebtRequest($this);
        }

        return $this;
    }

    public function removeDetailDebtRequest(DetailDebtRequest $detailDebtRequest): static
    {
        if ($this->detailDebtRequests->removeElement($detailDebtRequest)) {
            // set the owning side to null (unless already changed)
            if ($detailDebtRequest->getDebtRequest() === $this) {
                $detailDebtRequest->setDebtRequest(null);
            }
        }

        return $this;
    }
}
