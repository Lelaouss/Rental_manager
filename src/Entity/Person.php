<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="person_adress_FK", columns={"id_adress"})})
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 * @UniqueEntity(
 *     fields={"mail"},
 *     message="Cet adresse email est déjà utilisé par un autre utilisateur."
 * )
 */
class Person
{
	const GENDER_FEMALE = "Mme";
	const GENDER_MALE = "M.";
	
	const SITUATION_SINGLE = "Célibataire";
	const SITUATION_MARRIED_FEMALE = "Mariée";
	const SITUATION_MARRIED_MALE = "Marié";
	const SITUATION_DIVORCED_FEMALE = "Divorcée";
	const SITUATION_DIVORCED_MALE = "Divorcé";
	const SITUATION_WIDOWED_FEMALE = "Veuve";
	const SITUATION_WIDOWED_MALE = "Veuf";
	
    /**
     * @var int
     *
     * @ORM\Column(name="id_person", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
	 * @Assert\NotBlank()
	 */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="middle_name", type="string", length=255, nullable=true, options={"default"=NULL})
     */
    private $middleName = NULL;

    /**
     * @var integer
     *
     * @ORM\Column(name="civility", type="integer", nullable=false)
	 * @Assert\Range(
	 *     min="0",
	 *     max="1",
	 *     invalidMessage="La civilité d'une personne ne peut être inférieure à 0 et supèrieure à 1."
	 * )
     */
    private $civility;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birthday", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $birthday = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=true, options={"default"=NULL})
	 * @Assert\Email(message="Veuillez renseigner une adresse mail valide.")
     */
    private $mail = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cell_phone", type="string", length=45, nullable=true, options={"default"=NULL})
     */
    private $cellPhone = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="landline_phone", type="string", length=45, nullable=true, options={"default"=NULL})
     */
    private $landlinePhone = NULL;

    /**
     * @var integer|null
     *
     * @ORM\Column(name="family_situation", type="integer", nullable=true, options={"default"=NULL})
     */
    private $familySituation = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="occupation", type="string", length=255, nullable=true, options={"default"=NULL})
     */
    private $occupation = NULL;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="banished", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $banished = NULL;

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
     * @ORM\ManyToMany(targetEntity="Rent", mappedBy="idTenant")
     */
    private $idRent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Property", mappedBy="idOwner")
     */
    private $idProperty;
	
	/**
	 * @var string
	 */
    private $titleCivility;
    
	/**
	 * @var string
	 */
    private $titleFamilySituation;
	
	/**
	 * @var string
	 */
    private $fullName;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idRent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idProperty = new \Doctrine\Common\Collections\ArrayCollection();
        $this->civility = 0;
    }

    public function getIdPerson(): ?int
    {
        return $this->idPerson;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getCivility(): ?int
    {
		$this->setTitleCivility();
    	
        return $this->civility;
    }

    public function setCivility(int $civility): self
    {
        $this->civility = $civility;
        
        $this->setTitleCivility();

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCellPhone(): ?string
    {
        return $this->cellPhone;
    }

    public function setCellPhone(?string $cellPhone): self
    {
        $this->cellPhone = $cellPhone;

        return $this;
    }

    public function getLandlinePhone(): ?string
    {
        return $this->landlinePhone;
    }

    public function setLandlinePhone(?string $landlinePhone): self
    {
        $this->landlinePhone = $landlinePhone;

        return $this;
    }

    public function getFamilySituation(): ?int
    {
		$this->setTitleFamilySituation();
    	
        return $this->familySituation;
    }

    public function setFamilySituation(?int $familySituation): self
    {
        $this->familySituation = $familySituation;
        
        $this->setTitleFamilySituation();

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): self
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function getBanished(): ?\DateTimeInterface
    {
        return $this->banished;
    }

    public function setBanished(?\DateTimeInterface $banished): self
    {
        $this->banished = $banished;

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
            $idRent->addIdTenant($this);
        }

        return $this;
    }

    public function removeIdRent(Rent $idRent): self
    {
        if ($this->idRent->contains($idRent)) {
            $this->idRent->removeElement($idRent);
            $idRent->removeIdTenant($this);
        }

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
            $idProperty->addIdOwner($this);
        }

        return $this;
    }

    public function removeIdProperty(Property $idProperty): self
    {
        if ($this->idProperty->contains($idProperty)) {
            $this->idProperty->removeElement($idProperty);
            $idProperty->removeIdOwner($this);
        }

        return $this;
    }
	
	public function getTitleCivility(): string
	{
		return $this->titleCivility;
	}
	
	public function setTitleCivility(): self
	{
		switch ($this->civility) {
			case 0:
				$this->titleCivility = self::GENDER_FEMALE;
				break;
			case 1:
				$this->titleCivility = self::GENDER_MALE;
				break;
			default:
				$this->titleCivility = self::GENDER_FEMALE;
				break;
		}
		
		return $this;
	}
	
	public function getTitleFamilySituation(): string
	{
		return $this->titleFamilySituation;
	}
	
	public function setTitleFamilySituation(): self
	{
		switch ($this->familySituation) {
			case 0:
				$this->titleFamilySituation = self::SITUATION_SINGLE;
				break;
			case 1:
				$this->titleFamilySituation = self::SITUATION_MARRIED_MALE;
				if ($this->civility == "0") {
					$this->titleFamilySituation = self::SITUATION_MARRIED_FEMALE;
				}
				break;
			case 2:
				$this->titleFamilySituation = self::SITUATION_DIVORCED_MALE;
				if ($this->civility == "0") {
					$this->titleFamilySituation = self::SITUATION_DIVORCED_FEMALE;
				}
				break;
			case 3:
				$this->titleFamilySituation = self::SITUATION_WIDOWED_MALE;
				if ($this->civility == "0") {
					$this->titleFamilySituation = self::SITUATION_WIDOWED_FEMALE;
				}
				break;
			default:
				$this->titleFamilySituation = self::SITUATION_SINGLE;
				break;
		}
		
		return $this;
	}
	
	private function setFullName()
	{
		$this->setTitleCivility();
		
		$this->fullName = $this->titleCivility . " " . $this->firstName . " " . $this->lastName;
	}
	
	public function getFullName(): string
	{
		$this->setFullName();
		
		return $this->fullName;
	}
	
}
