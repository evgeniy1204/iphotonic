<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: EventRepository::class),
    ORM\Table(name: 'events'),
]
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

    #[ORM\Column(name: 'created_event_start_at', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdEventStartAt = null;

    #[ORM\Column(name: 'created_event_end_at', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdEventEndAt = null;

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

    public function getCreatedEventStartAt(): ?\DateTimeInterface
    {
        return $this->createdEventStartAt;
    }

    public function setCreatedEventStartAt(\DateTimeInterface $createdEventStartAt): static
    {
        $this->createdEventStartAt = $createdEventStartAt;

        return $this;
    }

    public function getCreatedEventEndAt(): ?\DateTimeInterface
    {
        return $this->createdEventEndAt;
    }

    public function setCreatedEventEndAt(\DateTimeInterface $createdEventEndAt): static
    {
        $this->createdEventEndAt = $createdEventEndAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $dateTime): void
    {
        $this->createdAt = $dateTime;
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
