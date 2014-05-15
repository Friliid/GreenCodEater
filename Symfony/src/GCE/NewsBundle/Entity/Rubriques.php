<?php

namespace GCE\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rubriques
 *
 * @ORM\Table(name="rubriques", indexes={@ORM\Index(name="fk_Rubriques_Site_idx", columns={"SiteId"}), @ORM\Index(name="fk_Rubriques_Lang1_idx", columns={"LangId"})})
 * @ORM\Entity
 */
class Rubriques
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \Site
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Site")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SiteId", referencedColumnName="id")
     * })
     */
    private $siteId;

    /**
     * @var \Lang
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Lang")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LangId", referencedColumnName="id")
     * })
     */
    private $langId;



    /**
     * Set id
     *
     * @param integer $id
     * @return Rubriques
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Rubriques
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Rubriques
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set siteid
     *
     * @param \GCE\NewsBundle\Entity\Site $siteid
     * @return Rubriques
     */
    public function setSiteid(\GCE\NewsBundle\Entity\Site $siteid)
    {
        $this->siteid = $siteid;

        return $this;
    }

    /**
     * Get siteid
     *
     * @return \GCE\NewsBundle\Entity\Site 
     */
    public function getSiteid()
    {
        return $this->siteid;
    }

    /**
     * Set langid
     *
     * @param \GCE\NewsBundle\Entity\Lang $langid
     * @return Rubriques
     */
    public function setLangid(\GCE\NewsBundle\Entity\Lang $langid)
    {
        $this->langid = $langid;

        return $this;
    }

    /**
     * Get langid
     *
     * @return \GCE\NewsBundle\Entity\Lang 
     */
    public function getLangid()
    {
        return $this->langid;
    }
}
