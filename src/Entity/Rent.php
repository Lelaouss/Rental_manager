<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rent
 *
 * @ORM\Table(name="rent", indexes={@ORM\Index(name="rent_property_FK", columns={"id_property"})})
 * @ORM\Entity(repositoryClass="App\Repository\RentRepository")
 */
class Rent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $endDate = NULL;

    /**
     * @var float
     *
     * @ORM\Column(name="rent_amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $rentAmount;

    /**
     * @var float
     *
     * @ORM\Column(name="rent_charges", type="float", precision=10, scale=0, nullable=false)
     */
    private $rentCharges;

    /**
     * @var float
     *
     * @ORM\Column(name="rent_total_amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $rentTotalAmount;

    /**
     * @var float
     *
     * @ORM\Column(name="rent_guarantee", type="float", precision=10, scale=0, nullable=false)
     */
    private $rentGuarantee;

    /**
     * @var bool
     *
     * @ORM\Column(name="furnished", type="boolean", nullable=false)
     */
    private $furnished;

    /**
     * @var \Property
     *
     * @ORM\ManyToOne(targetEntity="Property")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_property", referencedColumnName="id_property")
     * })
     */
    private $idProperty;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Document", inversedBy="idRent")
     * @ORM\JoinTable(name="document__rent",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_rent", referencedColumnName="id_rent")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_document", referencedColumnName="id_document")
     *   }
     * )
     */
    private $idDocument;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="idRent")
     * @ORM\JoinTable(name="person__rent",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_rent", referencedColumnName="id_rent")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_tenant", referencedColumnName="id_person")
     *   }
     * )
     */
    private $idTenant;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="idRentGurantor")
     * @ORM\JoinTable(name="person__rent__guarantor",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_rent_gurantor", referencedColumnName="id_rent")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_guarantor", referencedColumnName="id_person")
     *   }
     * )
     */
    private $idGuarantor;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idDocument = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idTenant = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idGuarantor = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdRent(): ?int
    {
        return $this->idRent;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRentAmount(): ?float
    {
        return $this->rentAmount;
    }

    public function setRentAmount(float $rentAmount): self
    {
        $this->rentAmount = $rentAmount;

        return $this;
    }

    public function getRentCharges(): ?float
    {
        return $this->rentCharges;
    }

    public function setRentCharges(float $rentCharges): self
    {
        $this->rentCharges = $rentCharges;

        return $this;
    }

    public function getRentTotalAmount(): ?float
    {
        return $this->rentTotalAmount;
    }

    public function setRentTotalAmount(float $rentTotalAmount): self
    {
        $this->rentTotalAmount = $rentTotalAmount;

        return $this;
    }

    public function getRentGuarantee(): ?float
    {
        return $this->rentGuarantee;
    }

    public function setRentGuarantee(float $rentGuarantee): self
    {
        $this->rentGuarantee = $rentGuarantee;

        return $this;
    }

    public function getFurnished(): ?bool
    {
        return $this->furnished;
    }

    public function setFurnished(bool $furnished): self
    {
        $this->furnished = $furnished;

        return $this;
    }

    public function getIdProperty(): ?Property
    {
        return $this->idProperty;
    }

    public function setIdProperty(?Property $idProperty): self
    {
        $this->idProperty = $idProperty;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getIdDocument(): Collection
    {
        return $this->idDocument;
    }

    public function addIdDocument(Document $idDocument): self
    {
        if (!$this->idDocument->contains($idDocument)) {
            $this->idDocument[] = $idDocument;
        }

        return $this;
    }

    public function removeIdDocument(Document $idDocument): self
    {
        if ($this->idDocument->contains($idDocument)) {
            $this->idDocument->removeElement($idDocument);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getIdTenant(): Collection
    {
        return $this->idTenant;
    }

    public function addIdTenant(Person $idTenant): self
    {
        if (!$this->idTenant->contains($idTenant)) {
            $this->idTenant[] = $idTenant;
        }

        return $this;
    }

    public function removeIdTenant(Person $idTenant): self
    {
        if ($this->idTenant->contains($idTenant)) {
            $this->idTenant->removeElement($idTenant);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getIdGuarantor(): Collection
    {
        return $this->idGuarantor;
    }

    public function addIdGuarantor(Person $idGuarantor): self
    {
        if (!$this->idGuarantor->contains($idGuarantor)) {
            $this->idGuarantor[] = $idGuarantor;
        }

        return $this;
    }

    public function removeIdGuarantor(Person $idGuarantor): self
    {
        if ($this->idGuarantor->contains($idGuarantor)) {
            $this->idGuarantor->removeElement($idGuarantor);
        }

        return $this;
    }

}
