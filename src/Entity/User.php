<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="user_person_AK", columns={"id_person"})}, indexes={@ORM\Index(name="user_user_type0_FK", columns={"id_user_type"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=45, nullable=false, unique=true)
	 * @Assert\Length(
	 *     min=3,
	 *     max=45,
	 *     minMessage="L'identifiant renseigné est trop court (minimum 3 caractères).",
	 *     maxMessage="L'identifiant renseigné est trop long (maximum 45 caractères)."
	 * )
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;
	
	/**
	 * @var string
	 *
	 * @Assert\EqualTo(propertyPath="password", message="Doit être identique au mot de passe.")
	 */
	private $passwordConfirm;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="banished", type="datetime", nullable=true, options={"default"=NULL})
     */
    private $banished = NULL;

    /**
     * @var \Person
     *
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_person", referencedColumnName="id_person", nullable=false)
     * })
     */
    private $idPerson;

    /**
     * @var \UserType
     *
     * @ORM\ManyToOne(targetEntity="UserType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_type", referencedColumnName="id_user_type", nullable=false)
     * })
     */
    private $idUserType;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
	
	public function getPasswordConfirm(): ?string
	{
		return $this->passwordConfirm;
	}
	
	public function setPasswordConfirm(string $password): self
	{
		$this->passwordConfirm = $password;
		
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

    public function getIdPerson(): ?Person
    {
        return $this->idPerson;
    }

    public function setIdPerson(?Person $idPerson): self
    {
        $this->idPerson = $idPerson;

        return $this;
    }

    public function getIdUserType(): ?UserType
    {
        return $this->idUserType;
    }

    public function setIdUserType(?UserType $idUserType): self
    {
        $this->idUserType = $idUserType;

        return $this;
    }
	
	/**
	 * Returns the roles granted to the user.
	 *
	 *     public function getRoles()
	 *     {
	 *         return ['ROLE_USER'];
	 *     }
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 *
	 * @return array (Role|string)[] The user roles
	 */
	public function getRoles()
	{
		$idRoleUser = $this->getIdUserType();
		$labelRoleUser = $idRoleUser->getLabel();
		
		return [$labelRoleUser];
	}
	
	/**
	 * Returns the salt that was originally used to encode the password.
	 *
	 * This can return null if the password was not encoded using a salt.
	 *
	 * @return string|null The salt
	 */
	public function getSalt()
	{
	}
	
	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername()
	{
		return $this->getLogin();
	}
	
	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 */
	public function eraseCredentials()
	{
	}

}
