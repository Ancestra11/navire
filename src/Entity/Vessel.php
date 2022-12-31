<?php

namespace App\Entity;

use App\Repository\VesselRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VesselRepository::class)]
class Vessel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mmsi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImo(): ?string
    {
        return $this->imo;
    }

    public function setImo(?string $imo): self
    {
        $this->imo = $imo;

        return $this;
    }

    public function getMmsi(): ?string
    {
        return $this->mmsi;
    }

    public function setMmsi(?string $mmsi): self
    {
        $this->mmsi = $mmsi;

        return $this;
    }
}
