<?php

namespace App\Entity;

use App\Repository\ContactGroupRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactGroupRepository::class)]
#[ORM\Table(name: 'contact_group')]
#[ORM\Index(name: 'IDX_40EA54CA82D40A1F', fields: ['workspace'])]
final class ContactGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private(set) ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Workspace::class, inversedBy: 'contactGroups')]
    #[ORM\JoinColumn(nullable: false)]
    public ?Workspace $workspace = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    public ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['default' => 'CURRENT_TIMESTAMP'])]
    public ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    public ?DateTimeImmutable $deletedAt = null;

    /** @var Collection<int, Contact> */
    #[ORM\ManyToMany(targetEntity: Contact::class, mappedBy: 'groups')]
    public Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return $this
     */
    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }
        if (!$contact->groups->contains($this)) {
            $contact->addGroup($this);
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function removeContact(Contact $contact): self
    {
        $this->contacts->removeElement($contact);
        if ($contact->groups->contains($this)) {
            $contact->removeGroup($this);
        }
        return $this;
    }
}
