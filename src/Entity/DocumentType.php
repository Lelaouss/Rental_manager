<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentType
 *
 * @ORM\Table(name="document_type")
 * @ORM\Entity(repositoryClass="App\Repository\DocumentTypeRepository")
 */
class DocumentType
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
	
	
	/**
     * @var int
     *
     * @ORM\Column(name="id_document_type", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDocumentType;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" : 1})
     */
    private $active;
	
	
	/**
	 * DocumentType constructor.
	 */
	public function __construct()
	{
		$this->active = self::STATUS_ENABLED;
	}
	
	public function getIdDocumentType(): ?int
    {
        return $this->idDocumentType;
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }


}
