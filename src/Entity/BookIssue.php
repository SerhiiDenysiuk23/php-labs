<?php

namespace App\Entity;

use App\Repository\BookIssueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookIssueRepository::class)]
#[ORM\Table(name: 'book_issues')]
#[ORM\HasLifecycleCallbacks]
class BookIssue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: 'issues')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Book $book = null;

    #[ORM\ManyToOne(targetEntity: Reader::class, inversedBy: 'issues')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Reader $reader = null;

    #[ORM\Column(name: 'issued_at', type: 'datetime')]
    private \DateTimeInterface $issuedAt;

    #[ORM\OneToOne(targetEntity: BookReturn::class, mappedBy: 'bookIssue', cascade: ['persist', 'remove'])]
    private ?BookReturn $bookReturn = null;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;
        return $this;
    }

    public function getReader(): ?Reader
    {
        return $this->reader;
    }

    public function setReader(?Reader $reader): static
    {
        $this->reader = $reader;
        return $this;
    }

    public function getIssuedAt(): \DateTimeInterface
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(\DateTimeInterface $issuedAt): static
    {
        $this->issuedAt = $issuedAt;
        return $this;
    }

    public function getBookReturn(): ?BookReturn
    {
        return $this->bookReturn;
    }

    public function setBookReturn(BookReturn $bookReturn): static
    {
        if ($bookReturn->getBookIssue() !== $this) {
            $bookReturn->setBookIssue($this);
        }

        $this->bookReturn = $bookReturn;
        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
