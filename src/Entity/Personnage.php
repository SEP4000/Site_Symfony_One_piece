<?php

namespace App\Entity;

use App\Repository\PersonnageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnageRepository::class)]
class Personnage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $nom_p = null;

    #[ORM\Column(length: 20)]
    private ?string $prenom_p = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $age = null;

    #[ORM\Column(length: 30)]
    private ?string $apparition_manga = null;

    #[ORM\Column(length: 30)]
    private ?string $apparition_anime = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $personnage_img = null;

    #[ORM\ManyToOne(targetEntity: Arc::class,inversedBy: 'personnage')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Arc $arc;

    #[ORM\OneToMany(mappedBy: 'personnages', targetEntity: Comment::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nom_p;
    }

    public function setNomP(?string $nom_p): self
    {
        $this->nom_p = $nom_p;

        return $this;
    }

    public function getPrenomP(): ?string
    {
        return $this->prenom_p;
    }

    public function setPrenomP(string $prenom_p): self
    {
        $this->prenom_p = $prenom_p;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(?string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getApparitionManga(): ?string
    {
        return $this->apparition_manga;
    }

    public function setApparitionManga(string $apparition_manga): self
    {
        $this->apparition_manga = $apparition_manga;

        return $this;
    }

    public function getApparitionAnime(): ?string
    {
        return $this->apparition_anime;
    }

    public function setApparitionAnime(string $apparition_anime): self
    {
        $this->apparition_anime = $apparition_anime;

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

    public function getPersonnageImg(): ?string
    {
        return $this->personnage_img;
    }

    public function setPersonnageImg(?string $personnage_img): self
    {
        $this->personnage_img = $personnage_img;

        return $this;
    }

    public function getArc(): ?Arc
    {
        return $this->arc;
    }

    public function setArc(?Arc $arc): self
    {
        $this->arc = $arc;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPersonnages($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPersonnages() === $this) {
                $comment->setPersonnages(null);
            }
        }

        return $this;
    }
}
