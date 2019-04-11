<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 *
 * @ORM\Table(name="property", indexes={@ORM\Index(name="property_adress_FK", columns={"id_adress"})})
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 */
class Property
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_property", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProperty;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=45, nullable=false)
     */
    private $label;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="construction_date", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $constructionDate = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="purchase_date", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $purchaseDate = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="purchase_price", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $purchasePrice = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="sale_date", type="datetime", nullable=true, options={"default"="NULL"})
     */
    private $saleDate = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="sale_price", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $salePrice = NULL;

    /**
     * @var float|null
     *
     * @ORM\Column(name="surface_area", type="float", precision=10, scale=0, nullable=true, options={"default"="NULL"})
     */
    private $surfaceArea = NULL;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nb_rooms", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $nbRooms = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="details", type="text", length=0, nullable=true, options={"default"="NULL"})
     */
    private $details = NULL;

    /**
     * @var \Adress
     *
     * @ORM\ManyToOne(targetEntity="Adress")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_adress", referencedColumnName="id_adress")
     * })
     */
    private $idAdress;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Document", mappedBy="idProperty")
     */
    private $idDocument;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="idProperty")
     * @ORM\JoinTable(name="property__owner",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_property", referencedColumnName="id_property")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_owner", referencedColumnName="id_person")
     *   }
     * )
     */
    private $idOwner;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idDocument = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idOwner = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdProperty(): ?int
    {
        return $this->idProperty;
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

    public function getConstructionDate(): ?\DateTimeInterface
    {
        return $this->constructionDate;
    }

    public function setConstructionDate(?\DateTimeInterface $constructionDate): self
    {
        $this->constructionDate = $constructionDate;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?\DateTimeInterface $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?float $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getSaleDate(): ?\DateTimeInterface
    {
        return $this->saleDate;
    }

    public function setSaleDate(?\DateTimeInterface $saleDate): self
    {
        $this->saleDate = $saleDate;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }

    public function setSalePrice(?float $salePrice): self
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    public function getSurfaceArea(): ?float
    {
        return $this->surfaceArea;
    }

    public function setSurfaceArea(?float $surfaceArea): self
    {
        $this->surfaceArea = $surfaceArea;

        return $this;
    }

    public function getNbRooms(): ?int
    {
        return $this->nbRooms;
    }

    public function setNbRooms(?int $nbRooms): self
    {
        $this->nbRooms = $nbRooms;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getIdAdress(): ?Adress
    {
        return $this->idAdress;
    }

    public function setIdAdress(?Adress $idAdress): self
    {
        $this->idAdress = $idAdress;

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
            $idDocument->addIdProperty($this);
        }

        return $this;
    }

    public function removeIdDocument(Document $idDocument): self
    {
        if ($this->idDocument->contains($idDocument)) {
            $this->idDocument->removeElement($idDocument);
            $idDocument->removeIdProperty($this);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getIdOwner(): Collection
    {
        return $this->idOwner;
    }

    public function addIdOwner(Person $idOwner): self
    {
        if (!$this->idOwner->contains($idOwner)) {
            $this->idOwner[] = $idOwner;
        }

        return $this;
    }

    public function removeIdOwner(Person $idOwner): self
    {
        if ($this->idOwner->contains($idOwner)) {
            $this->idOwner->removeElement($idOwner);
        }

        return $this;
    }

}
