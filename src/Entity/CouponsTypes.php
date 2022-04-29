<?php

namespace App\Entity;

use App\Repository\CouponsTypesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponsTypesRepository::class)]
class CouponsTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'coupons_types', targetEntity: CouponsName::class, orphanRemoval: true)]
    private $couponsNames;

    public function __construct()
    {
        $this->couponsNames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, CouponsName>
     */
    public function getCouponsNames(): Collection
    {
        return $this->couponsNames;
    }

    public function addCouponsName(CouponsName $couponsName): self
    {
        if (!$this->couponsNames->contains($couponsName)) {
            $this->couponsNames[] = $couponsName;
            $couponsName->setCouponsTypes($this);
        }

        return $this;
    }

    public function removeCouponsName(CouponsName $couponsName): self
    {
        if ($this->couponsNames->removeElement($couponsName)) {
            // set the owning side to null (unless already changed)
            if ($couponsName->getCouponsTypes() === $this) {
                $couponsName->setCouponsTypes(null);
            }
        }

        return $this;
    }
}
