<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Membre::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_membre;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicule::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_vehicule;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_heure_depart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_heure_fin;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_total;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_enregistrement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMembre(): ?membre
    {
        return $this->id_membre;
    }

    public function setIdMembre(?membre $id_membre): self
    {
        $this->id_membre = $id_membre;

        return $this;
    }

    public function getIdVehicule(): ?vehicule
    {
        return $this->id_vehicule;
    }

    public function setIdVehicule(?vehicule $id_vehicule): self
    {
        $this->id_vehicule = $id_vehicule;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->date_heure_depart;
    }

    public function setDateHeureDepart(\DateTimeInterface $date_heure_depart): self
    {
        $this->date_heure_depart = $date_heure_depart;

        return $this;
    }

    public function getDateHeureFin(): ?\DateTimeInterface
    {
        return $this->date_heure_fin;
    }

    public function setDateHeureFin(\DateTimeInterface $date_heure_fin): self
    {
        $this->date_heure_fin = $date_heure_fin;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prix_total;
    }

    public function setPrixTotal(int $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeInterface $date_enregistrement): self
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

}
