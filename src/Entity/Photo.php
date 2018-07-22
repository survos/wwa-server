<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="photo")
     */
    private $locations;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $mural = false;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $jpegData;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->setMural(false);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setPhoto($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getPhoto() === $this) {
                $location->setPhoto(null);
            }
        }

        return $this;
    }

    public function getMural(): ?bool
    {
        return $this->mural;
    }

    public function setMural(bool $mural): self
    {
        $this->mural = $mural;

        return $this;
    }

    public function getJpegData()
    {
        return $this->jpegData;
    }

    public function setJpegData($jpegData): self
    {
        $this->jpegData = $jpegData;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
