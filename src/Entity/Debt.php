<?php

namespace App\Entity;

use App\Repository\DebtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[Groups(["debt.api.index"])]
#[ORM\Entity(repositoryClass: DebtRepository::class)]
class Debt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["payment.api.index"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["payment.api.index"])]
    private ?int $mount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["payment.api.index"])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $paid_mount = null;

    #[ORM\Column]
    private ?int $remaining_mount = null;

    #[ORM\Column]
    #[Groups(["payment.api.index"])]
    private ?bool $is_achieved = null;

    /**
     * @var Collection<int, DetailDebt>
     */
    #[ORM\OneToMany(targetEntity: DetailDebt::class, mappedBy: 'debt', orphanRemoval: true, cascade: ['persist'])]
    private Collection $detailDebts;

    #[ORM\ManyToOne(inversedBy: 'debts')]
    private ?Client $client = null;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'debt')]
    private Collection $payments;

    public function __construct()
    {
        $this->detailDebts = new ArrayCollection();
        $this->payments = new ArrayCollection();
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

    public function getMount(): ?int
    {
        return $this->mount;
    }

    public function setMount(int $mount): static
    {
        $this->mount = $mount;

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

    public function getPaidMount(): ?int
    {
        return $this->paid_mount;
    }

    public function setPaidMount(int $paid_mount): static
    {
        $this->paid_mount = $paid_mount;

        return $this;
    }

    public function getRemainingMount(): ?int
    {
        return $this->remaining_mount;
    }

    public function setRemainingMount(int $remaining_mount): static
    {
        $this->remaining_mount = $remaining_mount;

        return $this;
    }

    public function isAchieved(): ?bool
    {
        return $this->is_achieved;
    }

    public function setAchieved(bool $is_achieved): static
    {
        $this->is_achieved = $is_achieved;

        return $this;
    }

    /**
     * @return Collection<int, DetailDebt>
     */
    public function getDetailDebts(): Collection
    {
        return $this->detailDebts;
    }

    public function setDetailDebts(Collection $detailDebts): void
    {
        $this->detailDebts = $detailDebts;
    }

    public function addDetailDebt(DetailDebt $detailDebt): static
    {
        if (!$this->detailDebts->contains($detailDebt)) {
            $this->detailDebts->add($detailDebt);
            $detailDebt->setDebt($this);
        }

        return $this;
    }

    public function removeDetailDebt(DetailDebt $detailDebt): static
    {
        if ($this->detailDebts->removeElement($detailDebt)) {
            // set the owning side to null (unless already changed)
            if ($detailDebt->getDebt() === $this) {
                $detailDebt->setDebt(null);
            }
        }

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
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setDebt($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getDebt() === $this) {
                $payment->setDebt(null);
            }
        }

        return $this;
    }
}
