<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="document", indexes={@ORM\Index(name="document_document_type_FK", columns={"id_document_type"})})
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
	
	
	/**
     * @var int
     *
     * @ORM\Column(name="id_document", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDocument;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" : 1})
     */
    private $active;

    /**
     * @var \DocumentType
     *
     * @ORM\ManyToOne(targetEntity="DocumentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_document_type", referencedColumnName="id_document_type")
     * })
     */
    private $idDocumentType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Property", inversedBy="idDocument")
     * @ORM\JoinTable(name="document__property",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_document", referencedColumnName="id_document")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_property", referencedColumnName="id_property")
     *   }
     * )
     */
    private $idProperty;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Rent", mappedBy="idDocument")
     */
    private $idRent;

    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->active = self::STATUS_ENABLED;
        $this->idProperty = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idRent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdDocument(): ?int
    {
        return $this->idDocument;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getIdDocumentType(): ?DocumentType
    {
        return $this->idDocumentType;
    }

    public function setIdDocumentType(?DocumentType $idDocumentType): self
    {
        $this->idDocumentType = $idDocumentType;

        return $this;
    }

    /**
     * @return Collection|Property[]
     */
    public function getIdProperty(): Collection
    {
        return $this->idProperty;
    }

    public function addIdProperty(Property $idProperty): self
    {
        if (!$this->idProperty->contains($idProperty)) {
            $this->idProperty[] = $idProperty;
        }

        return $this;
    }

    public function removeIdProperty(Property $idProperty): self
    {
        if ($this->idProperty->contains($idProperty)) {
            $this->idProperty->removeElement($idProperty);
        }

        return $this;
    }

    /**
     * @return Collection|Rent[]
     */
    public function getIdRent(): Collection
    {
        return $this->idRent;
    }

    public function addIdRent(Rent $idRent): self
    {
        if (!$this->idRent->contains($idRent)) {
            $this->idRent[] = $idRent;
            $idRent->addIdDocument($this);
        }

        return $this;
    }

    public function removeIdRent(Rent $idRent): self
    {
        if ($this->idRent->contains($idRent)) {
            $this->idRent->removeElement($idRent);
            $idRent->removeIdDocument($this);
        }

        return $this;
    }

}
