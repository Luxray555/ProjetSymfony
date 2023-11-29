<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Vich\UploadableField(mapping: 'pp_user', fileNameProperty: 'ppImageName', size: 'ppImageSize')]
    private ?File $ppImageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $ppImageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $ppImageSize = null;

    #[Vich\UploadableField(mapping: 'banner_user', fileNameProperty: 'bannerImageName', size: 'bannerImageSize')]
    private ?File $bannerImageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $bannerImageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $bannerImageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Note::class)]
    private Collection $notes;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: ReponseTicket::class)]
    private Collection $reponseTickets;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->reponseTickets = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->id . ' - ' . $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPpImageName(): ?string
    {
        return $this->ppImageName;
    }

    public function setPpImageName(?string $ppImageName): void
    {
        $this->ppImageName = $ppImageName;
    }

    public function getPpImageSize(): ?int
    {
        return $this->ppImageSize;
    }

    public function setPpImageSize(?int $ppImageSize): void
    {
        $this->ppImageSize = $ppImageSize;
    }

    public function getBannerImageName(): ?string
    {
        return $this->bannerImageName;
    }

    public function setBannerImageName(?string $bannerImageName): void
    {
        $this->bannerImageName = $bannerImageName;
    }

    public function getBannerImageSize(): ?int
    {
        return $this->bannerImageSize;
    }

    public function setBannerImageSize(?int $bannerImageSize): void
    {
        $this->bannerImageSize = $bannerImageSize;
    }

    public function getPpImageFile(): ?File
    {
        return $this->ppImageFile;
    }

    public function setPpImageFile(?File $ppImageFile = null): void
    {
        $this->ppImageFile = $ppImageFile;

        if (null !== $ppImageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getBannerImageFile(): ?File
    {
        return $this->bannerImageFile;
    }

    public function setBannerImageFile(?File $bannerImageFile = null): void
    {
        $this->bannerImageFile = $bannerImageFile;

        if (null !== $bannerImageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setUser($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getUser() === $this) {
                $note->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReponseTicket>
     */
    public function getReponseTickets(): Collection
    {
        return $this->reponseTickets;
    }

    public function addReponseTicket(ReponseTicket $reponseTicket): static
    {
        if (!$this->reponseTickets->contains($reponseTicket)) {
            $this->reponseTickets->add($reponseTicket);
            $reponseTicket->setAuteur($this);
        }

        return $this;
    }

    public function removeReponseTicket(ReponseTicket $reponseTicket): static
    {
        if ($this->reponseTickets->removeElement($reponseTicket)) {
            // set the owning side to null (unless already changed)
            if ($reponseTicket->getAuteur() === $this) {
                $reponseTicket->setAuteur(null);
            }
        }

        return $this;
    }
}
