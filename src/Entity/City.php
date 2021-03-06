<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city", indexes={@ORM\Index(name="city_county_FK", columns={"id_county"})})
 * @ORM\Entity
 */
class City
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_city", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCity;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=false)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="county_code", type="string", length=3, nullable=false)
     */
    private $countyCode;

    /**
     * @var \County
     *
     * @ORM\ManyToOne(targetEntity="County")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_county", referencedColumnName="id_county")
     * })
     */
    private $idCounty;

    public function getIdCity(): ?int
    {
        return $this->idCity;
    }
	
	public function setIdCity($idCity): self
	{
		$this->idCity = $idCity;
		
		return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountyCode(): ?string
    {
        return $this->countyCode;
    }

    public function setCountyCode(string $countyCode): self
    {
        $this->countyCode = $countyCode;

        return $this;
    }

    public function getIdCounty(): ?County
    {
        return $this->idCounty;
    }

    public function setIdCounty(?County $idCounty): self
    {
        $this->idCounty = $idCounty;

        return $this;
    }


}
