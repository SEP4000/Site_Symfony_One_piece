<?php

namespace App\Entity;

use App\Repository\ArcRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArcRepository::class)]
class Arc
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nom_a = null;

    #[ORM\Column(length: 30)]
    private ?string $nbr_chap = null;

    #[ORM\Column(length: 30)]
    private ?string $nbr_anime = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $desription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $arc_img = null;

    #[ORM\OneToMany(mappedBy: 'arc', targetEntity: Personnage::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $personnage;

    #[ORM\OneToMany(mappedBy: 'arcs', targetEntity: Comment::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $comments;

    public function __construct()
    {
        $this->personnage = new ArrayCollection();
        $this->comments = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomA(): ?string
    {
        return $this->nom_a;
    }

    public function setNomA(string $nom_a): self
    {
        $this->nom_a = $nom_a;

        return $this;
    }

    public function getNbrChap(): ?string
    {
        return $this->nbr_chap;
    }

    public function setNbrChap(string $nbr_chap): self
    {
        $this->nbr_chap = $nbr_chap;

        return $this;
    }

    public function getNbrAnime(): ?string
    {
        return $this->nbr_anime;
    }

    public function setNbrAnime(string $nbr_anime): self
    {
        $this->nbr_anime = $nbr_anime;

        return $this;
    }

    public function getDesription(): ?string
    {
        return $this->desription;
    }

    public function setDesription(string $desription): self
    {
        $this->desription = $desription;

        return $this;
    }

    public function getArcImg(): ?string
    {
        return $this->arc_img;
    }

    public function setArcImg(?string $arc_img): self
    {
        $this->arc_img = $arc_img;

        return $this;
    }

    /**
     * @return Collection<int, Personnage>
     */
    public function getPersonnage(): Collection
    {
        return $this->personnage;
    }

    public function addPersonnage(Personnage $personnage): self
    {
        if (!$this->personnage->contains($personnage)) {
            $this->personnage->add($personnage);
            $personnage->setArc($this);
        }

        return $this;
    }

    public function removePersonnage(Personnage $personnage): self
    {
        if ($this->personnage->removeElement($personnage)) {
            // set the owning side to null (unless already changed)
            if ($personnage->getArc() === $this) {
                $personnage->setArc(null);
            }
        }

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
            $comment->setArcs($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArcs() === $this) {
                $comment->setArcs(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_a;
    }
}
