<?php

namespace KSH\BibeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Baby
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KSH\BibeBundle\Entity\BabyRepository")
 * @Vich\Uploadable
 */
class Baby
{
    /**
    * @ORM\OneToMany(targetEntity="KSH\BibeBundle\Entity\Biberon", mappedBy="baby", cascade={"remove","persist"})
    * @ORM\OrderBy({"date" = "DESC"})
    */
    private $biberons; // Notez le « s », une annonce est liée à plusieurs biberons
    

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="psedo", type="string", length=255)
     */
    private $psedo;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birth_date", type="datetime")
     */
    private $birthDate;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=255)
     */
    private $sex;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bibi_start_date", type="datetime")
     */
    private $bibiStartDate;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="baby_image", fileNameProperty="imageName")
     * 
     * @var File $imageFile
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;
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
     * Set psedo
     *
     * @param string $psedo
     * @return Baby
     */
    public function setPsedo($psedo)
    {
        $this->psedo = $psedo;

        return $this;
    }

    /**
     * Get psedo
     *
     * @return string 
     */
    public function getPsedo()
    {
        return $this->psedo;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Baby
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Baby
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return Baby
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return Baby
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set bibiStartDate
     *
     * @param \DateTime $bibiStartDate
     * @return Baby
     */
    public function setBibiStartDate($bibiStartDate)
    {
        $this->bibiStartDate = $bibiStartDate;

        return $this;
    }

    /**
     * Get bibiStartDate
     *
     * @return \DateTime 
     */
    public function getBibiStartDate()
    {
        return $this->bibiStartDate;
    }

    /**
     * Add biberon
     *
     * @param \KSH\BibeBundle\Entity\Biberon $biberon
     * @return Baby
     */
    public function addBiberon(Biberon $biberon)
    {
        $this->biberons[] = $biberon;

        $biberon->setBaby($this);
    
        return $this;
    }

    /**
     * Remove biberon
     *
     * @param \KSH\BibeBundle\Entity\Biberon $biberon
     */
    public function removeBiberon(Biberon $biberon)
    {
        $this->biberons->removeElement($biberon);
    }

    /**
     * Get biberons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBiberons()
    {
        return $this->biberons;
    }


    public function __construct()
    {
        $this->biberons = new ArrayCollection();
        $this->birthDate = new \Datetime();
        $this->bibiStartDate = new \Datetime();
    // ...
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

}
