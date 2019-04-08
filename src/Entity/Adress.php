<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adress
 *
 * @ORM\Table(name="adress", indexes={@ORM\Index(name="adress_city_FK", columns={"id_city"})})
 * @ORM\Entity
 */
class Adress
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_adress", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdress;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=false)
     */
    private $street;

    /**
     * @var string|null
     *
     * @ORM\Column(name="additional_adress", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $additionalAdress = 'NULL';

    /**
     * @var \City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_city", referencedColumnName="id_city")
     * })
     */
    private $idCity;

    public function getIdAdress(): ?int
    {
        return $this->idAdress;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getAdditionalAdress(): ?string
    {
        return $this->additionalAdress;
    }

    public function setAdditionalAdress(?string $additionalAdress): self
    {
        $this->additionalAdress = $additionalAdress;

        return $this;
    }

    public function getIdCity(): ?City
    {
        return $this->idCity;
    }

    public function setIdCity(?City $idCity): self
    {
        $this->idCity = $idCity;

        return $this;
    }


}
