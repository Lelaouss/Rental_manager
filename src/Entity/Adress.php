<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Adress
 *
 * @ORM\Table(name="adress", indexes={@ORM\Index(name="adress_city_FK", columns={"id_city"})})
 * @ORM\Entity(repositoryClass="App\Repository\AdressRepository")
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
	 * @Assert\Length(
	 * 		min = 3,
	 *    	max = 255,
	 *    	minMessage = "L'adresse du local doit faire au minimum 3 caractères.",
	 *   	maxMessage = "L'adresse du local doit faire au maximum 255 caractères."
	 * )
	 */
    private $street;

    /**
     * @var string|null
     *
     * @ORM\Column(name="additional_adress", type="string", length=255, nullable=true)
     */
    private $additionalAdress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_code", type="string", length=45, nullable=true)
     */
    private $zipCode;

    /**
     * @var \City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_city", referencedColumnName="id_city", nullable=false)
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

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

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
