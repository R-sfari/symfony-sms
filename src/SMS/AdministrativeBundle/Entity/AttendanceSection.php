<?php

namespace SMS\AdministrativeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AttendanceStudent
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="attendance_section")
 * @ORM\Entity(repositoryClass="SMS\AdministrativeBundle\Repository\AttendanceSectionRepository")
 */
class AttendanceSection
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * Many Attendances have One Session.
     * @ORM\ManyToOne(targetEntity="SMS\StudyPlanBundle\Entity\Session")
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id")
     */
    private $session;

    /**
     * Many Attendances have One Course.
     * @ORM\ManyToOne(targetEntity="SMS\StudyPlanBundle\Entity\Course",fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $course;

    /**
     * Many Attendance Section have One Section.
     * @ORM\ManyToOne(targetEntity="SMS\EstablishmentBundle\Entity\Section" ,fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    private $section;

    /**
     * One attendanceStudent has Many attendanceSection.
     * @ORM\OneToMany(targetEntity="AttendanceStudent", mappedBy="attendanceSection",fetch="EXTRA_LAZY")
     */
     private $attendanceStudent;

     /**
      * @var \DateTime $created
      *
      * @ORM\Column(type="datetime")
      */
     protected $created;

     /**
      * @var \DateTime $updated
      *
      * @ORM\Column(type="datetime", nullable = true)
      */
     protected $updated;

     /**
      * One User has Many Divivsions.
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
     *
     * @return AttendanceSection
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
     * Set session
     *
     * @param \SMS\StudyPlanBundle\Entity\Session $session
     *
     * @return AttendanceSection
     */
    public function setSession(\SMS\StudyPlanBundle\Entity\Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \SMS\StudyPlanBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set course
     *
     * @param \SMS\StudyPlanBundle\Entity\Course $course
     *
     * @return AttendanceSection
     */
    public function setCourse(\SMS\StudyPlanBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \SMS\StudyPlanBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set section
     *
     * @param \SMS\EstablishmentBundle\Entity\Section $section
     *
     * @return AttendanceSection
     */
    public function setSection(\SMS\EstablishmentBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \SMS\EstablishmentBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attendanceStudent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return AttendanceSection
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
     * @return AttendanceSection
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
     * Add attendanceStudent
     *
     * @param \SMS\AdministrativeBundle\Entity\AttendanceStudent $attendanceStudent
     *
     * @return AttendanceSection
     */
    public function addAttendanceStudent(\SMS\AdministrativeBundle\Entity\AttendanceStudent $attendanceStudent)
    {
        $this->attendanceStudent[] = $attendanceStudent;

        return $this;
    }

    /**
     * Remove attendanceStudent
     *
     * @param \SMS\AdministrativeBundle\Entity\AttendanceStudent $attendanceStudent
     */
    public function removeAttendanceStudent(\SMS\AdministrativeBundle\Entity\AttendanceStudent $attendanceStudent)
    {
        $this->attendanceStudent->removeElement($attendanceStudent);
    }

    /**
     * Get attendanceStudent
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttendanceStudent()
    {
        return $this->attendanceStudent;
    }

    /**
     * Set user
     *
     * @param \SMS\UserBundle\Entity\User $user
     *
     * @return AttendanceSection
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
}
