<?php

namespace App\Entity;

use App\Repository\TypeplanqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TypePlanqueRepository::class)
 */
class TypePlanque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Nom obligatoire")
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Planque::class, mappedBy="type")
     */
    private $planques;

    public function __construct()
    {
        $this->planques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPlanques(): Collection
    {
        return $this->planques;
    }

    public function addPlanque(Planque $planque): self
    {
        if (!$this->planques->contains($planque)) {
            $this->planques->add($planque);
            $planque->setType($this);
        }

        return $this;
    }

    public function removePlanque(Planque $planque): self
    {
        if ($this->planques->removeElement($planque)) {
            // set the owning side to null (unless already changed)
            if ($planque->getType() === $this) {
                $planque->setType(null);
            }
        }

        return $this;
    }

    public function setPlanques(Collection $planques): self
    {
        $this->planques = $planques;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}