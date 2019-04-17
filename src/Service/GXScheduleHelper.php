<?php
/**
 * Created by PhpStorm.
 * User: cippio
 * Date: 2/22/19
 * Time: 7:51 AM
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\Gx\ScheduledClassRepository;


class GXScheduleHelper
{
    /**
     * @var ScheduledClassRepository
     */
    private $scheduledClassRepository;

    public function __construct(ScheduledClassRepository $scheduledClassRepository)
    {
        $this->scheduledClassRepository = $scheduledClassRepository;
    }

    public function getAllScheduledClasses(): array
    {
        return $this->scheduledClassRepository->findAll();
    }

    public function getStartTime(?string $time): ?\DateTime
    {
        return ($time == null) ? null : new \DateTime($time);
    }
    public function getEndTime(?string $time): ?\DateTime
    {
        return ($time == null) ? null : new \DateTime($time);
    }

    public function getStartDate(?string $date): ?\DateTime
    {
        return ($date == null) ? null : new \DateTime($date);
    }

    public function getEndDate(?string $date): ?\DateTime
    {
        return ($date == null) ? null : new \DateTime($date);
    }

    public function getDayOfWeek(?\DateTime $date): ?string
    {
        if ($date == null ) { return null; }
        $newDate = $date->format('Y-m-d');
        $temp = strtotime($newDate);
        return date('l',$temp);
    }
    public function checkStartTime(?string $time): array
    {
        if ($time == null ) { return ["startTime" => "Starting time is required."]; }

        /*
         * This can be used along with location hours to make sure the start time
         * is during club hours.
         * $linuxTime = strtotime($time);
         * $hr = date('H', $linuxTime);
         * $min = date('i', $linuxTime);
         * dd($hr . ':' . $min);
         * */

        return [];
    }

    public function checkEndTime(?string $time): array
    {
        if ($time == null ) { return ["endTime" => "Ending time is required."]; }
        return [];
    }

    public function getClassesOnDay(?string $day): array
    {
        if($day == null) { return ["byDay" => "Input day was null or empty"]; }

        return $this->scheduledClassRepository->findAllScheduledClassesByDay($day);
    }

    public function getClassesOnDate(?string $date): array
    {
        if($date == null) { return ["byDate" => "Input date was null or empty"]; }

        $testDate = $this->getStartDate($date);
        $day = $this->getDayOfWeek($testDate);

        return $this->scheduledClassRepository->findAllScheduledClassesByDate($testDate, $day);
    }

    public function getClassAtLocation(?int $id): array
    {
        if($id == null) { return []; }
        return $this->scheduledClassRepository->findAllScheduledClassesByLocation($id);
    }

//    public function getClassesOnDayAtLocation(?string $day, ?string $loc): array
//    {
//        if( $day == null || $loc == null ) { return []; }
//
//        $classes = $this->scheduledClassRepository->findAllScheduledClassesByDay($day);
//
//        if (count($classes) < 1) { return []; }
//
//        return $this->andGetByLocation($classes, $loc);
//    }

    /**
     * @param string|null $date
     * @param string|null $loc
     * @return array
     */
//    public function getClassesOnDateAtLocation(?string $date, ?string $loc): array
//    {
//        if( $date == null || $loc == null ) { return []; }
//
//        $classDate = $this->getStartDate($date);
//        $classDay = $this->getDayOfWeek($classDate);
//
//        $classes = $this->scheduledClassRepository->findAllScheduledClassesByDate($classDate, $classDay);
//        if (count($classes) < 1) { return []; }
//
//        return $this->andGetByLocation($classes, $loc);
//    }
}
