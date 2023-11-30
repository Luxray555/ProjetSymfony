<?php

namespace App\Entity;

use App\Repository\AnimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AnimeRepository::class)]
#[Vich\Uploadable]
class Anime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $synopsis = null;

    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'anime', targetEntity: Note::class)]
    private Collection $notes;

    #[Vich\UploadableField(mapping: 'cover_anime', fileNameProperty: 'coverImageName', size: 'coverImageSize')]
    private ?File $coverImageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $coverImageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $coverImageSize = null;

    #[Vich\UploadableField(mapping: 'banner_anime', fileNameProperty: 'bannerImageName', size: 'bannerImageSize')]
    private ?File $bannerImageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $bannerImageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $bannerImageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateAjout = null;

    #[ORM\ManyToMany(targetEntity: Genre::class, mappedBy: 'animes')]
    #[Assert\Count(min: 1, minMessage: "L'anime doit avoir au moins un genre.")]
    private Collection $genres;

    #[ORM\ManyToOne(inversedBy: 'animes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimeStatus $status = null;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->dateAjout = new \DateTimeImmutable();
        $this->genres = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->id . ' - ' . $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(?string $imgUrl): static
    {
        $this->imgUrl = $imgUrl;

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
            $commentaire->setAnime($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getAnime() === $this) {
                $commentaire->setAnime(null);
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
            $note->setAnime($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getAnime() === $this) {
                $note->setAnime(null);
            }
        }

        return $this;
    }

    public function setCoverImageFile(?File $coverImageFile = null): void
    {
        $this->coverImageFile = $coverImageFile;

        if (null !== $coverImageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCoverImageFile(): ?File
    {
        return $this->coverImageFile;
    }

    public function setCoverImageName(?string $coverImageName): void
    {
        $this->coverImageName = $coverImageName;
    }

    public function getCoverImageName(): ?string
    {
        return $this->coverImageName;
    }

    public function setCoverImageSize(?int $coverImageSize): void
    {
        $this->coverImageSize = $coverImageSize;
    }

    public function getCoverImageSize(): ?int
    {
        return $this->coverImageSize;
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

    public function getBannerImageFile(): ?File
    {
        return $this->bannerImageFile;
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

    public function getDateAjout(): ?\DateTimeImmutable
    {
        return $this->dateAjout;
    }

    public function setDateAjout(?\DateTimeImmutable $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addAnime($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeAnime($this);
        }

        return $this;
    }

    public function getStatus(): ?AnimeStatus
    {
        return $this->status;
    }

    public function setStatus(?AnimeStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}
