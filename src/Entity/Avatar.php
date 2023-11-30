<?php

namespace App\Entity;

use App\Repository\AvatarRepository;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Ignore;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AvatarRepository::class)]
#[Vich\Uploadable]
class Avatar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'pp_user', fileNameProperty: 'ppImageName', size: 'ppImageSize')]
    #[Ignore]
    protected ?File $ppImageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $ppImageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $ppImageSize = null;

    #[Vich\UploadableField(mapping: 'banner_user', fileNameProperty: 'bannerImageName', size: 'bannerImageSize')]
    #[Ignore]
    protected ?File $bannerImageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $bannerImageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $bannerImageSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
