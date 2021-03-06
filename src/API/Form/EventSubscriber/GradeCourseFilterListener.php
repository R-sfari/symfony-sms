<?php

namespace API\Form\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManager;
use SMS\EstablishmentBundle\Entity\Grade;
use SMS\EstablishmentBundle\Entity\Division;
use SMS\StudyPlanBundle\Entity\Course;

/**
 * Class GradeCourseFilterListener
 *
 * @author Rami Sfari <rami2sfari@gmail.com>
 * @copyright Copyright (c) 2017, SMS
 * @package API\Form\EventSubscriber
 */
class GradeCourseFilterListener implements EventSubscriberInterface
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
            FormEvents::PRE_SET_DATA => 'onPreSetData'
            );
    }

    /**
     * Set form field
     *
     * @param FormInterface $form
     * @param Grade $grade
     * @return Void
     */
    public function addElements(FormInterface $form, Grade $grade = null , Division $division = null) {

        // Add the grade element
        $form->add('grade' , EntityType::class , array(
                    'data'          => $grade,
                    'class'         => Grade::class,
                    'property'      => 'gradeName',
                    'placeholder'   => 'course.field.grade',
                    'mapped'        => false,
                    'label'         => 'course.field.grade',
                    'attr'          => [ 'class'=> 'gradeField'])
        );

        // Add the grade element
        $form->add('division' , EntityType::class , array(
                    'data'       => $division,
                    'class'         => Division::class,
                    'property'      => 'divisionName',
                    'placeholder'   => 'filter.field.division',
                    'mapped'        => false,
                    'label'         => 'filter.field.division',
                    'attr'          => [ 'class'=> 'divisionField'])
        );

        $courses = array();
        if ($grade && $division) {
            // Fetch the course from specified grade
            $courses = $this->em->getRepository(Course::class)->findByGradeAndDivision($grade , $division);
        }
        // Add the Course element
        $form->add('course' , EntityType::class , array(
                    'class' => Course::class,
                    'property' => 'courseName',
                    'choices'       => $courses,
                    'placeholder'=> 'filter.field.course',
                    'label' => 'filter.field.course',
                    'attr'          => [ 'class'=> 'courseField'])
                );

    }

    /**
     * {@inheritdoc}
     */
    public function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        // Note that the data is not yet hydrated into the entity.
        $grade = $this->em->getRepository(Grade::class)->find($data['grade']);
        $division = $this->em->getRepository(Division::class)->find($data['division']);
        $this->addElements($form, $grade , $division);
    }

    /**
     * {@inheritdoc}
     */
    public function onPreSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        // We might have an empty data (when we insert a new data, for instance)
        $grade = $data->getCourse() ? $data->getCourse()->getGrade() : null;
        $this->addElements($form, $grade);
    }

}
