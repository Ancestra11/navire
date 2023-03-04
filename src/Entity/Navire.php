<?php

namespace App\Entity;

use App\Repository\NavireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table (name:'navire')]
#[Assert\Unique(fields:['imo','mmsi','indicatifAppel'])]
#[ORM\Entity(repositoryClass: NavireRepository::class)]
#[ORM\Index(name:'ind_IMO', columns:['imo'])]
#[ORM\Index(name:'ind_MMSI', columns:['mmsi'])]
class Navire
{    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name:'id')]
    private ?int $id = null;

    #[ORM\Column(length: 7)]
    #[Assert\Regex('[1-9][0-9]{6}', message:'Le numéro IMO doit êrte unique, composé de 7 chiffres sans commencer par 0')]
    private ?string $imo = null;

    #[ORM\Column(name:'nom', length: 255)]
    #[Assert\Range(
        min: 3,
        max: 255,
        message: 'Le nom du navire doit faire 3 charactères au mimimum',
    )]
    private ?string $nom = null;

    #[ORM\Column(name:'mmsi', length: 9)]
    #[Assert\Regex('[1-9][0-9]{9}', message:'Le numéro MMSI doit êrte unique, composé de 10 chiffres sans commencer par 0')]
    private ?string $mmsi = null;

    #[ORM\Column(name:'indicatifappel', length: 10)]
    private ?string $indicatifappel = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $eta = null;

    #[ORM\Column(name:'longueur')]
    private ?int $longueur = null;

    #[ORM\Column(name:'largeur')]
    private ?int $largeur = null;

    #[ORM\Column(name:'tirantdeau')]
    private ?float $tirantdeau = null;

    #[ORM\ManyToOne(inversedBy:'navires')]
    #[ORM\JoinColumn(name:'idaisshiptype', referencedColumnName:'id', nullable:false)]
    private ?AisShipType $aisShipType = null;

    #[ORM\ManyToOne(inversedBy:'navires')]
    #[ORM\JoinColumn(name:'idpays', referencedColumnName:'id', nullable:false)]
    private ?Pays $pavillon = null;
    
    #[ORM\ManyToOne(inversedBy:'navires', cascade:['persist'])]
    #[ORM\JoinColumn(name:'idport', referencedColumnName:'id', nullable:true)]
    private ?Port $destination = null;

    #[ORM\OneToMany(mappedBy: 'navire', targetEntity: Escale::class, orphanRemoval: true)]
    private Collection $escales;

    public function __construct()
    {
        $this->escales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImo(): ?string
    {
        return $this->imo;
    }

    public function setImo(string $imo): self
    {
        $this->imo = $imo;

        return $this;
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

    public function getMmsi(): ?string
    {
        return $this->mmsi;
    }

    public function setMmsi(string $mmsi): self
    {
        $this->mmsi = $mmsi;

        return $this;
    }

    public function getIndicatifappel(): ?string
    {
        return $this->indicatifappel;
    }

    public function setIndicatifappel(string $indicatifappel): self
    {
        $this->indicatifappel = $indicatifappel;

        return $this;
    }

    public function getEta(): ?\DateTimeInterface
    {
        return $this->eta;
    }

    public function setEta(?\DateTimeInterface $eta): self
    {
        $this->eta = $eta;

        return $this;
    }

    public function getLongueur(): ?int
    {
        return $this->longueur;
    }

    public function setLongueur(int $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?int
    {
        return $this->largeur;
    }

    public function setLargeur(int $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getTirantdeau(): ?float
    {
        return $this->tirantdeau;
    }

    public function setTirantdeau(float $tirantdeau): self
    {
        $this->tirantdeau = $tirantdeau;

        return $this;
    }

    public function getAisShipType(): ?AisShipType
    {
        return $this->aisShipType;
    }

    public function setAisShipType(?AisShipType $aisShipType): self
    {
        $this->aisShipType = $aisShipType;

        return $this;
    }

    public function getPavillon(): ?Pays
    {
        return $this->pavillon;
    }

    public function setPavillon(?Pays $pavillon): self
    {
        $this->pavillon = $pavillon;

        return $this;
    }

    /**
     * @return Collection<int, Escale>
     */
    public function getEscales(): Collection
    {
        return $this->escales;
    }

    public function addEscale(Escale $escale): self
    {
        if (!$this->escales->contains($escale)) {
            $this->escales->add($escale);
            $escale->setHistoriqueNavire($this);
        }

        return $this;
    }

    public function removeEscale(Escale $escale): self
    {
        if ($this->escales->removeElement($escale)) {
            // set the owning side to null (unless already changed)
            if ($escale->getHistoriqueNavire() === $this) {
                $escale->setHistoriqueNavire(null);
            }
        }

        return $this;
    }
}
