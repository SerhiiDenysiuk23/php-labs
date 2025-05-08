<?php

namespace App\Entity;

use App\Repository\BookReturnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookReturnRepository::class)]
#[ORM\Table(name: 'book_returns')]
#[ORM\HasLifecycleCallbacks]
class BookReturn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\OneToOne(
        targetEntity: BookIssue::class,
        inversedBy: 'bookReturn',
        cascade: ['persist', 'remove']
    )]
    #[ORM\JoinColumn(name: 'book_issue_id', nullable: false, onDelete: 'CASCADE')]
    private ?BookIssue $bookIssue = null;

    #[ORM\Column(name: 'returned_at', type: 'datetime')]
    private \DateTimeInterface $returnedAt;

    #[ORM\Column(name: 'created_at', type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookIssue(): ?BookIssue
    {
        return $this->bookIssue;
    }

    public function setBookIssue(BookIssue $bookIssue): static
    {
        $this->bookIssue = $bookIssue;
        if ($bookIssue->getBookReturn() !== $this) {
            $bookIssue->setBookReturn($this);
        }
        return $this;
    }

    public function getReturnedAt(): \DateTimeInterface
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(\DateTimeInterface $returnedAt): static
    {
        $this->returnedAt = $returnedAt;
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
