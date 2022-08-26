<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=MembreRepository::class)
 * @UniqueEntity(fields={"pseudo"}, message="There is already an account with this pseudo")
 */
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Length(min=2, max=180, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $pseudo;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(min=2, max=20, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(min=2, max=20, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=5, max=50, minMessage="Il faut {{ limit }} caractères minimum !", maxMessage="Il faut au maximum {{ limit }} caractères !" )
     * @Assert\Email(message = "L'adresse e-mail: {{ value }} n'est pas valide !")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide !")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $civilite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_enregistrement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

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
