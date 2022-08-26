<?php

namespace App\Entity;

use App\Repository\VehiculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehiculeRepository::class)
 */
class Vehicule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\Length(min=2, max=200, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=2, max=50, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=2, max=50, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $modele;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\Length(min=2, max=200, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix_journalier;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_enregistrement;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="id_vehicule", orphanRemoval=true)
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
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

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrixJournalier(): ?int
    {
        return $this->prix_journalier;
    }

    public function setPrixJournalier(int $prix_journalier): self
    {
        $this->prix_journalier = $prix_journalier;

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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setIdVehicule($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getIdVehicule() === $this) {
                $commande->setIdVehicule(null);
            }
        }

        return $this;
    }
}
