<?php

namespace SMS\PaymentBundle\Repository;

/**
 * CatchUpLessonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CatchUpLessonRepository extends \Doctrine\ORM\EntityRepository
{
  /**
   * Get All CatchUp Lesson
   *
   * @return array
   */
  public function findAllRegistredStudent($catchUpLesson)
  {
      $query = $this->createQueryBuilder('catchUpLesson')
        ->innerJoin('catchUpLesson.student', 'student')
        ->addSelect("partial student.{id ,imageName , username , firstName , lastName , phone , email} as studentInfo")
        ->where('catchUpLesson.id = :catchUpLesson')
        ->groupBy('student')
        ->setParameter('catchUpLesson', $catchUpLesson->getId());
      return $query;
  }
}
