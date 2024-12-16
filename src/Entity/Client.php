<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 22)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    private ?User $user_account = null;

    /**
     * @var Collection<int, Debt>
     */
    #[ORM\OneToMany(targetEntity: Debt::class, mappedBy: 'client')]
    private Collection $debts;

    /**
     * @var Collection<int, DebtRequest>
     */
    #[ORM\OneToMany(targetEntity: DebtRequest::class, mappedBy: 'client')]
    private Collection $debtRequests;

    public function __construct()
    {
        $this->debts = new ArrayCollection();
        $this->debtRequests = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getUserAccount(): ?User
    {
        return $this->user_account;
    }

    public function setUserAccount(?User $user_account): static
    {
        $this->user_account = $user_account;

        return $this;
    }

    /**
     * @return Collection<int, Debt>
     */
    public function getDebts(): Collection
    {
        return $this->debts;
    }

    public function addDebt(Debt $debt): static
    {
        if (!$this->debts->contains($debt)) {
            $this->debts->add($debt);
            $debt->setClient($this);
        }

        return $this;
    }

    public function removeDebt(Debt $debt): static
    {
        if ($this->debts->removeElement($debt)) {
            // set the owning side to null (unless already changed)
            if ($debt->getClient() === $this) {
                $debt->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DebtRequest>
     */
    public function getDebtRequests(): Collection
    {
        return $this->debtRequests;
    }

    public function addDebtRequest(DebtRequest $debtRequest): static
    {
        if (!$this->debtRequests->contains($debtRequest)) {
            $this->debtRequests->add($debtRequest);
            $debtRequest->setClient($this);
        }

        return $this;
    }

    public function removeDebtRequest(DebtRequest $debtRequest): static
    {
        if ($this->debtRequests->removeElement($debtRequest)) {
            // set the owning side to null (unless already changed)
            if ($debtRequest->getClient() === $this) {
                $debtRequest->setClient(null);
            }
        }

        return $this;
    }
}
