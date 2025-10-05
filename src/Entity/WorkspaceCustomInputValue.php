<?php

namespace App\Entity;

use App\Repository\WorkspaceCustomInputValueRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute as Serializer;

#[ORM\Entity(repositoryClass: WorkspaceCustomInputValueRepository::class)]
#[ORM\Table(name: 'workspace_custom_input_value')]
#[ORM\Index(name: 'IDX_75101EA4A9FB0242', fields: ['workspaceCustomInput'])]
#[ORM\Index(name: 'IDX_75101EA4A76ED395', columns: ['userId'])]
#[ORM\Index(name: 'IDX_75101EA4E7A1254A', fields: ['contact'])]
final class WorkspaceCustomInputValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    #[Serializer\Groups(['api:workspace:detail'])]
    private(set) ?int $id = null;

    #[ORM\ManyToOne(targetEntity: WorkspaceCustomInput::class, inversedBy: 'values')]
    #[ORM\JoinColumn(name: 'workspace_custom_inputs_id', onDelete: 'CASCADE')]
    public ?WorkspaceCustomInput $workspaceCustomInput = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['unsigned' => true])]
    #[Serializer\Groups(['api:workspace:detail'])]
    public ?int $userId = null;

    #[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: 'customInputValues')]
    #[ORM\JoinColumn]
    public ?Contact $contact = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Serializer\Groups(['api:workspace:detail'])]
    public ?string $value = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    public ?DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[Serializer\Groups(['api:workspace:detail'])]
    public function getContactId(): ?int
    {
        return $this->contact?->id;
    }

    #[Serializer\Groups(['api:workspace:detail'])]
    public function getWorkspaceCustomInputId(): ?int
    {
        return $this->workspaceCustomInput?->id;
    }

    #[Serializer\Groups(['api:workspace:detail'])]
    public function getWorkspaceCustomInputName(): ?string
    {
        return $this->workspaceCustomInput?->name;
    }
}
