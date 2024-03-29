<?php

namespace App\Entity;

use App\Repository\PortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortRepository::class)]
#[ORM\Table(name:'port')]
#[Assert\Unique(fields:['indicatif'])]
#[ORM\Index(name:"ind_INDICATIF", columns:['indicatif'])]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id')]
    private ?int $id = null;

    #[ORM\Column(name:'nom', length: 70)]
    private ?string $nom = null;

    #[ORM\Column(name:'indicatif', length: 5)]
    #[ORM\Regex(pattern:"/[A-Z]{5}/", message:"L'indicatif Port a strictement 5 caractères")]
    private ?string $indicatif = null;
    
    #[ORM\ManyToMany(targetEntity:AisShipType::class, inversedBy:'portsCompatibles')]
    #[ORM\JoinTable(name:'porttypecompatible')]
    #[ORM\JoinColumn(name:'idport', referencedColumnName:'id')]
    #[ORM\InverseJoinColumn(name:'idaisshiptype', referencedColumnName:'id')]
    private Collection $types;
    
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name:'idpays', nullable: false, fetch:'EAGER')]
    private ?Pays $pays = null;
    
    #[ORM\OneToMany(mappedBy: 'destination', targetEntity: Navire::class)]
    private Collection $navires;

    #[ORM\OneToMany(mappedBy: 'port', targetEntity: Escale::class, orphanRemoval: true)]
    private Collection $escales;

    public function __construct()
    {
        $this->escales = new ArrayCollection();
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

    public function getIndicatif(): ?string
    {
        return $this->indicatif;
    }

    public function setIndicatif(string $indicatif): self
    {
        $this->indicatif = $indicatif;

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
            $escale->setHistoriquePort($this);
        }

        return $this;
    }

    public function removeEscale(Escale $escale): self
    {
        if ($this->escales->removeElement($escale)) {
            // set the owning side to null (unless already changed)
            if ($escale->getHistoriquePort() === $this) {
                $escale->setHistoriquePort(null);
            }
        }

        return $this;
    }
}
