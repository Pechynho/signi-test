<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute as Serializer;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ORM\Table(name: 'contact')]
#[ORM\UniqueConstraint(name: 'unique_contact_idx', columns: ['workspace_id', 'email'])]
#[ORM\Index(name: 'IDX_4C62E63882D40A1F', fields: ['workspace'])]
#[ORM\Index(name: 'IDX_4C62E63861220EA6', columns: ['creatorId'])]
#[ORM\Index(name: 'IDX_4C62E638727ACA70', fields: ['parent'])]
final class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    #[Serializer\Groups(['api:workspace:detail'])]
    #[Serializer\SerializedName('contact_id')]
    private(set) ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Workspace::class, inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    public ?Workspace $workspace = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['unsigned' => true])]
    public ?int $creatorId = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    public ?self $parent = null;

    /** @var Collection<int, self> */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    public Collection $children;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $email = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Serializer\Groups(['api:workspace:detail'])]
    public ?string $firstname = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Serializer\Groups(['api:workspace:detail'])]
    public ?string $lastname = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $mobile = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $birthDate = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $addressCity = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $addressStreet = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $addressZip = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $company = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $ico = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $dic = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $position = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $signatureFooter = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    public ?array $customData = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    public ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $deletedAt = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0])]
    public int $featureFlags = 0;

    /** @var Collection<int, ContactGroup> */
    #[ORM\ManyToMany(targetEntity: ContactGroup::class, inversedBy: 'contacts')]
    #[ORM\JoinTable(name: 'contacts_groups')]
    #[ORM\JoinColumn(name: 'contact_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'group_id', referencedColumnName: 'id')]
    public Collection $groups;

    /** @var Collection<int, WorkspaceCustomInputValue> */
    #[ORM\OneToMany(targetEntity: WorkspaceCustomInputValue::class, mappedBy: 'contact')]
    #[Serializer\Groups(['api:workspace:detail'])]
    public Collection $customInputValues;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->customInputValues = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    #[Serializer\Groups(['api:workspace:detail'])]
    public function getFullname(): string
    {
        return trim(($this->firstname ?? '') . ' ' . ($this->lastname ?? ''));
    }

    #[Serializer\Groups(['api:workspace:detail'])]
    public function getInitials(): string
    {
        $first = $this->firstname !== null && $this->firstname !== '' ? mb_substr($this->firstname, 0, 1) : '';
        $last = $this->lastname !== null && $this->lastname !== '' ? mb_substr($this->lastname, 0, 1) : '';
        return mb_strtoupper($first . $last);
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }
        if ($child->parent !== $this) {
            $child->parent = $this;
        }
        return $this;
    }

    public function removeChild(self $child): self
    {
        $this->children->removeElement($child);
        if ($child->parent === $this) {
            $child->parent = null;
        }
        return $this;
    }

    public function addGroup(ContactGroup $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
        }
        if (!$group->contacts->contains($this)) {
            $group->addContact($this);
        }
        return $this;
    }

    public function removeGroup(ContactGroup $group): self
    {
        $this->groups->removeElement($group);
        if ($group->contacts->contains($this)) {
            $group->removeContact($this);
        }
        return $this;
    }

    public function addCustomInputValue(WorkspaceCustomInputValue $customInputValue): self
    {
        if (!$this->customInputValues->contains($customInputValue)) {
            $this->customInputValues->add($customInputValue);
        }
        if ($customInputValue->contact !== $this) {
            $customInputValue->contact = $this;
        }
        return $this;
    }

    public function removeCustomInputValue(WorkspaceCustomInputValue $customInputValue): self
    {
        $this->customInputValues->removeElement($customInputValue);
        if ($customInputValue->contact === $this) {
            $customInputValue->contact = null;
        }
        return $this;
    }
}
