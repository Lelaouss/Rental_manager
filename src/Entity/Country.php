<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
	
	
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id_country", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $idCountry;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=255, nullable=false)
	 */
	private $name;
	
	/**
	 * @var bool
	 *
	 * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" : 0})
	 */
	private $active;
	
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\County", mappedBy="idCountry")
	 */
	private $counties;
	
	
	/**
	 * Country constructor.
	 */
	public function __construct()
	{
		$this->active = self::STATUS_DISABLED;
		$this->counties = new ArrayCollection();
	}
	
	public function getIdCountry(): ?int
	{
		return $this->idCountry;
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
	
	public function getActive(): ?bool
	{
		return $this->active;
	}
	
	public function setActive(bool $active): self
	{
		$this->active = $active;
		
		return $this;
	}
	
	/**
	 * @return Collection|County[]
	 */
	public function getCounties(): Collection
	{
		return $this->counties;
	}
	
	public function addCounty(County $county): self
	{
		if (!$this->counties->contains($county)) {
			$this->counties[] = $county;
			$county->setIdCountry($this);
		}
		
		return $this;
	}
	
	public function removeCounty(County $county): self
	{
		if ($this->counties->contains($county)) {
			$this->counties->removeElement($county);
			// set the owning side to null (unless already changed)
			if ($county->getIdCountry() === $this) {
				$county->setIdCountry(null);
			}
		}
		
		return $this;
	}
	
}
