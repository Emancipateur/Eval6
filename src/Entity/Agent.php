<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 */
class Agent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ParamConverter("post", options={"id" = "post_id"})
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Attention, le nom est obligatoire!")
     * @Assert\Length(
     *     min=3,
     *     max=20,
     *     minMessage= "Merci de remplir plus de 3 caractères.",
     *     maxMessage ="Merci de ne pas remplir plus de 20 caractères."
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Le prénom est obligatoire")
     * @Assert\Length(
     *     min=3,
     *     max=20,
     *     minMessage="Merci de remplir plus de 3 caractères.",
     *     maxMessage="Merci de ne pas remplir plus de 20 caractères."
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string")
     *
     */
    private $nom_code;

    /**
     * @ORM\ManyToOne(targetEntity=Nationalite::class, inversedBy="agents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nationalite;

    /**
     * @ORM\ManyToMany(targetEntity=Specialite::class)
     * @ORM\JoinTable(name="agent_specialite",
     *      joinColumns={@ORM\JoinColumn(name="agent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="specialite_id", referencedColumnName="id")}
     * )
     */
    private $specialites;

    /**
     * @ORM\ManyToMany(targetEntity=Mission::class)
     * @ORM\JoinTable(name="mission_agent",
     *      joinColumns={@ORM\JoinColumn(name="agent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="mission_id", referencedColumnName="id")}
     * )
     */
    private $missions;

    public function __construct()
    {
        $this->specialites = new ArrayCollection();
        $this->missions = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getNomCode(): ?string
    {
        return $this->nom_code;
    }

    public function setNomCode(string $nom_code): self
    {
        $this->nom_code = $nom_code;

        return $this;
    }

    public function getNationalite(): Nationalite
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialites(Specialite $specialite): self
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites->add($specialite);
            $specialite->addAgent($this);
        }

        return $this;
    }

    public function removeSpecialites(Specialite $specialite): self
    {
        if($this->specialites->removeElement($specialite)) {
            $specialite->removeAgent($this);
        }

        return $this;
    }

    public function setSpecialites(Collection $specialites): self
    {
        $this->specialites = $specialites;

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
            $mission->addAgent($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            $mission->removeAgent($this);
        }

        return $this;
    }

    public function setMissions(Collection $missions): self
    {
        $this->missions = $missions;

        return $this;
    }
}