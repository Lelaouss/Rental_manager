<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * County
 *
 * @ORM\Table(name="county", indexes={@ORM\Index(name="county_country_FK", columns={"id_country"})})
 * @ORM\Entity
 */
class County
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_county", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCounty;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3, nullable=false)
     */
    private $code;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var \Country
     *
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_country", referencedColumnName="id_country", nullable=false)
     * })
     */
    private $idCountry;

    public function getIdCounty(): ?int
    {
        return $this->idCounty;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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

    public function getIdCountry(): ?Country
    {
        return $this->idCountry;
    }

    public function setIdCountry(?Country $idCountry): self
    {
        $this->idCountry = $idCountry;

        return $this;
    }


}
