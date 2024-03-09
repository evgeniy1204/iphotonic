<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'events')]
#[ORM\HasLifecycleCallbacks]
class Event
{
    #[
        ORM\Id,
        ORM\GeneratedValue,
        ORM\Column
    ]
    private ?int $id = null;

    #[ORM\Column(name: 'title', length: 255)]
    private ?string $title = null;

    #[ORM\Column(name: 'created_event_start', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdEventStart = null;

    #[ORM\Column(name: 'created_event_end', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdEventEnd = null;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(name: 'text', type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedEventStart(): ?\DateTimeInterface
    {
        return $this->createdEventStart;
    }

    public function setCreatedEventStart(\DateTimeInterface $createdEventStart): static
    {
        $this->createdEventStart = $createdEventStart;

        return $this;
    }

    public function getCreatedEventEnd(): ?\DateTimeInterface
    {
        return $this->createdEventEnd;
    }

    public function setCreatedEventEnd(\DateTimeInterface $createdEventEnd): static
    {
        $this->createdEventEnd = $createdEventEnd;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }
}
