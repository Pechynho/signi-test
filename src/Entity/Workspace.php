<?php

namespace App\Entity;

use App\Repository\WorkspaceRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceRepository::class)]
#[ORM\Table(name: 'workspace')]
#[ORM\Index(name: 'IDX_8D94001932C8A3DE', columns: ['organizationId'])]
#[ORM\Index(name: 'IDX_8D940019727ACA70', fields: ['parent'])]
#[ORM\Index(name: 'IDX_8D9400199B6B5FBA', fields: ['account'])]
final class Workspace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private(set) ?int $id = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['unsigned' => true])]
    public ?int $organizationId = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn]
    public ?self $parent = null;

    /** @var Collection<int, self> */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    public Collection $children;

    #[ORM\Column(type: Types::STRING, length: 10)]
    public ?string $identityForm = null;

    #[ORM\Column(type: Types::STRING, length: 20)]
    public ?string $title = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $number = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $logo = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $background = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $primaryColor = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $layerColor = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $textColor = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $brandingFeature = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $hideTerms = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $autoAddSign = false;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $autoSignPlace = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['default' => 1])]
    public int $emailNotification = 1;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $urlRedirect = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $uneditableHeader = false;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $googleDriveId = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $googleDrivePath = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $googleDriveApiKey = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $googleDriveClientId = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    public ?string $email = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    public ?array $branding = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    public ?array $contractSettings = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $note = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $isDemo = false;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    public ?array $externalDrive = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $amlText = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $signFooterSetting = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    public bool $convertToPdfA = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    public bool $lockAfterSeal = true;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    public ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $deletedAt = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true, 'default' => 0])]
    public int $featureFlagsDelete = 0;

    #[ORM\Column(type: Types::STRING, length: 2, options: ['default' => 'cs'])]
    public string $locale = 'cs';

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $availableSignTypes = null;

    #[ORM\Column(type: Types::STRING, length: 10, nullable: true)]
    public ?string $defaultPhonePrefix = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    public ?array $login2faSettings = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    public ?string $webhookSettings = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    public ?int $accountId = null;

    /** @var Collection<int, Contact> */
    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'workspace')]
    public Collection $contacts;

    /** @var Collection<int, ContactGroup> */
    #[ORM\OneToMany(targetEntity: ContactGroup::class, mappedBy: 'workspace')]
    public Collection $contactGroups;

    /** @var Collection<int, WorkspaceCustomInput> */
    #[ORM\OneToMany(targetEntity: WorkspaceCustomInput::class, mappedBy: 'workspace')]
    public Collection $customInputs;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->contactGroups = new ArrayCollection();
        $this->customInputs = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return $this
     */
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

    /**
     * @return $this
     */
    public function removeChild(self $child): self
    {
        $this->children->removeElement($child);
        if ($child->parent === $this) {
            $child->parent = null;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }
        if ($contact->workspace !== $this) {
            $contact->workspace = $this;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function removeContact(Contact $contact): self
    {
        $this->contacts->removeElement($contact);
        if ($contact->workspace === $this) {
            $contact->workspace = null;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function addContactGroup(ContactGroup $contactGroup): self
    {
        if (!$this->contactGroups->contains($contactGroup)) {
            $this->contactGroups->add($contactGroup);
        }
        if ($contactGroup->workspace !== $this) {
            $contactGroup->workspace = $this;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function removeContactGroup(ContactGroup $contactGroup): self
    {
        $this->contactGroups->removeElement($contactGroup);
        if ($contactGroup->workspace === $this) {
            $contactGroup->workspace = null;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function addCustomInput(WorkspaceCustomInput $customInput): self
    {
        if (!$this->customInputs->contains($customInput)) {
            $this->customInputs->add($customInput);
        }
        if ($customInput->workspace !== $this) {
            $customInput->workspace = $this;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function removeCustomInput(WorkspaceCustomInput $customInput): self
    {
        $this->customInputs->removeElement($customInput);
        if ($customInput->workspace === $this) {
            $customInput->workspace = null;
        }
        return $this;
    }
}
