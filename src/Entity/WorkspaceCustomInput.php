<?php

namespace App\Entity;

use App\Repository\WorkspaceCustomInputRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceCustomInputRepository::class)]
#[ORM\Table(name: 'workspace_custom_input')]
#[ORM\Index(name: 'IDX_8D9044282D40A1F', fields: ['workspace'])]
final class WorkspaceCustomInput
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private(set) ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Workspace::class, inversedBy: 'customInputs')]
    #[ORM\JoinColumn]
    public ?Workspace $workspace = null;

    #[ORM\Column(type: Types::TEXT)]
    public ?string $name = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    public ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    public ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $deletedAt = null;

    /** @var Collection<int, WorkspaceCustomInputValue> */
    #[ORM\OneToMany(targetEntity: WorkspaceCustomInputValue::class, mappedBy: 'workspaceCustomInput', cascade: ['remove'])]
    public Collection $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return $this
     */
    public function addValue(WorkspaceCustomInputValue $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values->add($value);
        }
        if ($value->workspaceCustomInput !== $this) {
            $value->workspaceCustomInput = $this;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function removeValue(WorkspaceCustomInputValue $value): self
    {
        $this->values->removeElement($value);
        if ($value->workspaceCustomInput === $this) {
            $value->workspaceCustomInput = null;
        }
        return $this;
    }
}
