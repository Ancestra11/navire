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

    public function getId(): ?int
    {
        return $this->id;
    }
}
