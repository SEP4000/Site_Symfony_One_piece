<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeImmutable;
use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]

    private string $content;

    #[ORM\Column(type: 'boolean')]

    private bool $_isApproved = false;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    
    private Utilisateur $author;

    #[ORM\ManyToOne(targetEntity: Arc::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: true)]

    private Arc $arcs;

    #[ORM\ManyToOne(targetEntity: Personnage::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: true)]

    private Personnage $personnages;

    #[ORM\Column(type: 'datetime_immutable')]

    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getisApproved(): ?bool
    {
        return $this->_isApproved;
    }

    public function setisApproved(bool $_isApproved): self
    {
        $this->_isApproved = $_isApproved;

        return $this;
    }


    public function getAuthor(): ?Utilisateur
    {
        return $this->author;
    }

    public function setAuthor(?Utilisateur $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getArcs(): ?Arc
    {
        return $this->arcs;
    }

    public function setArcs(?Arc $arcs): self
    {
        $this->arcs = $arcs;

        return $this;
    }

    public function getPersonnages(): ?Personnage
    {
        return $this->personnages;
    }

    public function setPersonnages(?Personnage $personnages): self
    {
        $this->personnages = $personnages;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}