<?php

namespace App\Entity;

use App\Repository\NationaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NationaliteRepository::class)
 */
class Nationalite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Pays obligatoire")
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Nationalité obligatoire")
     */
    private $nationalite;

    /**
     * @ORM\Column(type="string")
     *
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=Agent::class, mappedBy="nationalite")
     */
    private $agents;

    /**
     * @ORM\OneToMany(targetEntity=Cible::class, mappedBy="nationalite")
     */
    private $cibles;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="nationalite")
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=Planque::class, mappedBy="nationalite")
     */
    private $planques;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="nationalite")
     */
    private $missions;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->cibles = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->planques = new ArrayCollection();
        $this->missions = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;;
    }

    /**
     * @return Collection|Agent[]
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents[] = $agent;
            $agent->setNationalite($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getNationalite() === $this) {
                $agent->setNationalite(null);
            }
        }

        return $this;
    }

    public function setAgents(Collection $agents): self
    {
        $this->agents = $agents;

        return $this;
    }

    public function getCibles(): Collection
    {
        return $this->cibles;
    }

    public function addCible(Cible $cible): self
    {
        if (!$this->cibles->contains($cible)) {
            $this->cibles[] = $cible;
            $cible->setNationalite($this);
        }

        return $this;
    }

    public function removeCible(Cible $cible): self
    {
        if ($this->cibles->removeElement($cible)) {
            // set the owning side to null (unless already changed)
            if ($cible->getNationalite() === $this) {
                $cible->setNationalite(null);
            }
        }

        return $this;
    }

    public function setCibles(Collection $cibles): self
    {
        $this->cibles = $cibles;

        return $this;
    }

    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setNationalite($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getNationalite() === $this) {
                $contact->setNationalite(null);
            }
        }

        return $this;
    }

    public function setContacts(Collection $contacts): self
    {
        $this->contacts = $contacts;

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
            $planque->setNationalite($this);
        }

        return $this;
    }

    public function removePlanque(Planque $planque): self
    {
        if ($this->planques->removeElement($planque)) {
            // set the owning side to null (unless already changed)
            if ($planque->getNationalite() === $this) {
                $planque->setNationalite(null);
            }
        }

        return $this;
    }

    public function setPlanques(Collection $planques): self
    {
        $this->planques = $planques;

        return $this;
    }

    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->setNationalite($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getNationalite() === $this) {
                $mission->setNationalite(null);
            }
        }

        return $this;
    }

    public function setMissions(Collection $missions): self
    {
        $this->missions = $missions;

        return $this;
    }

    public function __toString()
    {
        return $this->nationalite;
    }
}
