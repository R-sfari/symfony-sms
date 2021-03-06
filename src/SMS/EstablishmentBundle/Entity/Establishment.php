<?php

namespace SMS\EstablishmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Establishment
 *
 * @Vich\Uploadable
 * @ORM\Table(name="establishment")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("establishmentName")
 * @UniqueEntity("phone")
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass="SMS\EstablishmentBundle\Repository\EstablishmentRepository")
 */
class Establishment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="establishment_logo", fileNameProperty="imageName")
     * @var File
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     *
     * @var string
     */
    protected $imageName;


    /**
     * @var string
     *
     * @ORM\Column(name="establishmentName", type="string", length=100, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min = 2, max = 99)
     * @Assert\Regex(pattern="/^[a-z0-9 .\-]+$/i" ,match=true)
     */
    private $establishmentName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15, unique=true)
     * @Assert\Regex( pattern="/\d/"),
     * @Assert\NotBlank(),
     * @Assert\Length(
     *    min = 8,
     *    max = 20
     * )
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=120, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min = 2, max = 120)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=20)
     * @Assert\NotBlank()
     * @Assert\Length(min = 2, max = 20)
     */
    private $theme;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=150)
     * @Assert\NotBlank(),
     * @Assert\Length(
     *   min = 2,
     *   max = 150
     * )
     * @Assert\Regex(pattern="/^[a-z0-9 .\-]+$/i" ,match=true)

     */
    private $address;

    /**
     * @var datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected $updated;

    /**
     * One User has Many Establishments.
     * @ORM\ManyToOne(targetEntity="SMS\UserBundle\Entity\User" ,fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
   public function updatedTimestamps()
   {
       $this->setUpdated(new \DateTime('now'));

       if ($this->getCreated() == null) {
           $this->setCreated(new \DateTime('now'));
       }
   }

   /**
    * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
    * of 'UploadedFile' is injected into this setter to trigger the  update. If this
    * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
    * must be able to accept an instance of 'File' as the bundle will inject one here
    * during Doctrine hydration.
    *
    * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
    *
    * @return User
    */
   public function setImageFile(File $image = null)
   {
       $this->imageFile = $image;

       if ($image) {
           // It is required that at least one field changes if you are using doctrine
           // otherwise the event listeners won't be called and the file is lost
           $this->updatedAt = new \DateTimeImmutable();
       }

       return $this;
   }

   /**
    * {@inheritdoc}
    */
   public function setUpdatedAt($updatedAt)
   {
       $this->updatedAt = $updatedAt;

       return $this;
   }

   /**
    * {@inheritdoc}
    */
   public function getUpdatedAt()
   {
       return $this->updatedAt;
   }

   /**
    * @return File|null
    */
   public function getImageFile()
   {
       return $this->imageFile;
   }

   /**
    * Set image Name
    *
    * @param string $imageName
    *
    * @return Slider
    */
   public function setImageName($imageName)
   {
       $this->imageName = $imageName;

       return $this;
   }

   /**
    * Get image Name
    *
    * @return string
    */
   public function getImageName()
   {
       return $this->imageName;
   }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Establishment
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Establishment
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Establishment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set establishmentName
     *
     * @param string $establishmentName
     *
     * @return Establishment
     */
    public function setEstablishmentName($establishmentName)
    {
        $this->establishmentName = $establishmentName;

        return $this;
    }

    /**
     * Get establishmentName
     *
     * @return string
     */
    public function getEstablishmentName()
    {
        return $this->establishmentName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Establishment
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set user
     *
     * @param \SMS\UserBundle\Entity\User $user
     *
     * @return Establishment
     */
    public function setUser(\SMS\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SMS\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Establishment
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Establishment
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%s",$this->getEstablishmentName());
    }

    /**
     * Set theme
     *
     * @param string $theme
     *
     * @return Establishment
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
