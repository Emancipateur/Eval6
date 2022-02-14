<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use App\Validator\AgentSpecialiteMission;
use App\Validator\MissionCibleAgentNationality;
use App\Validator\MissionCibleAgentNationalityValidator;
use App\Validator\MissionContactMissionNationality;
use App\Validator\MissionContactMissionNationalityValidator;
use App\Validator\MissionPlanqueMissionNationality;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Attention, le titre doit être rempli!")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Attention, la description doit être remplie!")
     * @Assert\Length(
     *     min=10,
     *     max=255,
     *     minMessage= "Merci de remplir plus de 10 caractères.",
     *     maxMessage ="Merci de ne pas remplir plus de 255 caractères."
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="Attention, le nm de code doit être rempli!")
     * @Assert\Length(
     *     min=3,
     *     max=20,
     *     minMessage= "Merci de remplir plus de 3 caractères.",
     *     maxMessage ="Merci de ne pas remplir plus de 20 caractères."
     * )
     */
    private $nom_code;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;


    /**
     * @ORM\ManyToMany(targetEntity=Agent::class)
     * @ORM\JoinTable(name="mission_agent",
     *      joinColumns={@ORM\JoinColumn(name="mission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="agent_id", referencedColumnName="id")}
     * )
     */
    private $agents;

    /**
     * @ORM\ManyToOne(targetEntity=Specialite::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $specialite;

    /**
     * @ORM\ManyToOne(targetEntity=Nationalite::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nationalite;

    /**
     * @ORM\ManyToOne(targetEntity=StatutMission::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMission::class, inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Planque::class)
     * @ORM\JoinTable(name="mission_planque",
     *      joinColumns={@ORM\JoinColumn(name="mission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="planque_id", referencedColumnName="id")}
     * )
     */
    private $planques;

    /**
     * @ORM\ManyToMany(targetEntity=Contact::class)
     * @ORM\JoinTable(name="mission_contact",
     *      joinColumns={@ORM\JoinColumn(name="mission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")}
     * )
     */
    private $contacts;

    /**
     * @ORM\ManyToMany(targetEntity=Cible::class)
     * @ORM\JoinTable(name="mission_cible",
     *      joinColumns={@ORM\JoinColumn(name="mission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="cible_id", referencedColumnName="id")}
     * )
     */
    private $cibles;

    public function __construct()
    {
        $this->agents= new ArrayCollection();
        $this->cibles = new ArrayCollection();
        $this->contacts= new ArrayCollection();
        $this->planques= new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getAgents(): Collection|null
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
            $agent->addMission($this);
        }

        return $this;
    }


    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            $agent->removeMission($this);
        }

        return $this;
    }

    public function setAgents(Collection $agents): self
    {
        $this->agents = $agents;

        return $this;
    }

    public function getSpecialite(): Specialite|null
    {
        return $this->specialite;
    }

    public function setSpecialite(?Specialite $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getStatut(): StatutMission|null
    {
        return $this->statut;
    }

    public function setStatut(?StatutMission $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): TypeMission|null
    {
        return $this->type;
    }

    public function setType(?TypeMission $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTypeMission(): TypeMission
    {
        return $this->TypeMission;
    }

    public function setTypeMission(?TypeMission $TypeMission): self
    {
        $this->TypeMission = $TypeMission;

        return $this;
    }

    public function getPlanques(): Collection|null
    {
        return $this->planques;
    }

    public function addPlanque(Planque $planque): self
    {
        if (!$this->planques->contains($planque)) {
            $this->planques->add($planque);
            $planque->addMission($this);
        }

        return $this;
    }

    public function removePlanque(Planque $planque): self
    {
        if ($this->planques->removeElement($planque)) {
            $planque->removeMission($this);
        }

        return $this;
    }

    public function setPlanques(Collection $planques): self
    {
        $this->planques = $planques;

        return $this;
    }

    public function getContacts(): Collection|null
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->addMission($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            $contact->removeMission($this);
        }

        return $this;
    }

    public function setContacts(Collection $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function getCibles(): Collection|null
    {
        return $this->cibles;
    }

    public function addCible(Cible $cible): self
    {
        if (!$this->cibles->contains($cible)) {
            $this->cibles->add($cible);
            $cible->addMission($this);
        }

        return $this;
    }

    public function removeCible(Cible $cible): self
    {
        if ($this->cibles->removeElement($cible)) {
            $cible->removeMission($this);
        }

        return $this;
    }

    public function setCibles(Collection $cibles): self
    {
        $this->cibles = $cibles;

        return $this;
    }

    public function getNationalite(): Nationalite|null
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }


    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('agents', new MissionCibleAgentNationality());
        $metadata->addPropertyConstraint('contacts', new MissionContactMissionNationality());
        $metadata->addPropertyConstraint('planques', new MissionPlanqueMissionNationality());
        $metadata->addPropertyConstraint('agents', new AgentSpecialiteMission());
    }


}