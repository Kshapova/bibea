<?php

namespace KSH\BibeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Biberon
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KSH\BibeBundle\Entity\BiberonRepository")
 */
class Biberon
{
    /**
    * @ORM\ManyToOne(targetEntity="KSH\BibeBundle\Entity\Baby")
    * @ORM\JoinColumn(nullable=false)
    */
    private $baby;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="water_volume", type="integer")
     */
    private $waterVolume;

    /**
     * @var integer
     *
     * @ORM\Column(name="mesure", type="integer")
     */
    private $mesure;

    /**
     * @var string
     *
     * @ORM\Column(name="water_brand", type="string", length=255)
     */
    private $waterBrand;

    /**
     * @var string
     *
     * @ORM\Column(name="milk_brand", type="string", length=255)
     */
    private $milkBrand;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment = null;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Biberon
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set waterVolume
     *
     * @param integer $waterVolume
     * @return Biberon
     */
    public function setWaterVolume($waterVolume)
    {
        $this->waterVolume = $waterVolume;

        return $this;
    }

    /**
     * Get waterVolume
     *
     * @return integer 
     */
    public function getWaterVolume()
    {
        return $this->waterVolume;
    }

    /**
     * Set mesure
     *
     * @param integer $mesure
     * @return Biberon
     */
    public function setMesure($mesure)
    {
        $this->mesure = $mesure;

        return $this;
    }

    /**
     * Get mesure
     *
     * @return integer 
     */
    public function getMesure()
    {
        return $this->mesure;
    }

    /**
     * Set waterBrand
     *
     * @param string $waterBrand
     * @return Biberon
     */
    public function setWaterBrand($waterBrand)
    {
        $this->waterBrand = $waterBrand;

        return $this;
    }

    /**
     * Get waterBrand
     *
     * @return string 
     */
    public function getWaterBrand()
    {
        return $this->waterBrand;
    }

    /**
     * Set milkBrand
     *
     * @param string $milkBrand
     * @return Biberon
     */
    public function setMilkBrand($milkBrand)
    {
        $this->milkBrand = $milkBrand;

        return $this;
    }

    /**
     * Get milkBrand
     *
     * @return string 
     */
    public function getMilkBrand()
    {
        return $this->milkBrand;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Biberon
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set baby
     *
     * @param \KSH\BibeBundle\Entity\Baby $baby
     * @return Comment
     */
    public function setBaby(\KSH\BibeBundle\Entity\Baby $baby = null)
    {
        $this->baby = $baby;

        return $this;
    }

    /**
     * Get baby
     *
     * @return \KSH\BibeBundle\Entity\Baby 
     */
    public function getBaby()
    {
        return $this->baby;
    }
    public function __construct()
    {
        // Par défaut, la date de l'annonce est la date d'aujourd'hui
        $this->date = new \Datetime();
    }
}
