<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $compteur_km;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montant_ht;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $montant_a_payer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getlient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCompteurKm(): ?int
    {
        return $this->compteur_km;
    }

    public function setCompteurKm(?int $compteur_km): self
    {
        $this->compteur_km = $compteur_km;

        return $this;
    }

    public function getMontantHt(): ?int
    {
        return $this->montant_ht;
    }

    public function setMontantHt(?int $montant_ht): self
    {
        $this->montant_ht = $montant_ht;

        return $this;
    }

    public function getMontantAPayer(): ?int
    {
        return $this->montant_a_payer;
    }

    public function setMontantAPayer(?int $montant_a_payer): self
    {
        $this->montant_a_payer = $montant_a_payer;

        return $this;
    }
}
