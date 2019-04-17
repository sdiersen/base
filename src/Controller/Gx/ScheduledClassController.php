<?php

namespace App\Controller\Gx;

use App\Entity\Gx\ScheduledClass;
use App\Service\GXClassHelper;
use App\Service\GXScheduleHelper;
use App\Service\LocationHelper;
use App\Service\UserHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ScheduledClassController
 * @package App\Controller
 * @Route("/gx/schedule")
 */
class ScheduledClassController extends AbstractController
{
    /**
     * @Route("/", name="gx_scheduled_class_index")
     */
    public function index(GXClassHelper $classHelper, GXScheduleHelper $scheduleHelper, LocationHelper $locationHelper)
    {
        return $this->render('gx/scheduled_classes/index.html.twig', [
            //'allClasses' => $scheduleHelper->getClassesOnDateAtLocation("2019-02-28", "Monticello"),
            'allClasses' => $scheduleHelper->getClassAtLocation(1),
            'loc' => $locationHelper->getLocationById(2),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new", name="gx_scheduled_class_new")
     */
    public function new(Request $request,
                        GXClassHelper $classHelper,
                        UserHelper $userHelper,
                        LocationHelper $locationHelper,
                        GXScheduleHelper $scheduleHelper)
    {
        $errors = [];

        $scheduledClass = new ScheduledClass();

        if($request->isMethod('POST')) {
            $class = $classHelper->getClassFromShortName($request->request->get('classSelect'));
            if ($class == null) { $errors = array_merge($errors, ["classSelect" => "Must select the class to schedule"]); }

            $startTime = $request->request->get("startTime");
            $scheduleHelper->checkStartTime($startTime);



            $endTime = $request->request->get("endTime");
            $startDate = $request->request->get("startDate");
            $endDate = $request->request->get("endDate");
            $id = $request->request->get("instructorSelect");
            $instructor = $userHelper->getUserById($id);
            $location = $locationHelper->getLocationByName($request->request->get("locationSelect"));

            $scheduleHelper->getDayOfWeek($scheduleHelper->getStartDate($startDate));

            $scheduledClass->setLocation($location);
            $scheduledClass->setEndDate($scheduleHelper->getEndDate($endDate));
            $scheduledClass->setStartDate($scheduleHelper->getStartDate($startDate));
            $scheduledClass->setStartTime($scheduleHelper->getStartTime($startTime));
            $scheduledClass->setEndTime($scheduleHelper->getEndTime($endTime));
            $scheduledClass->setDayOfWeek($scheduleHelper->getDayOfWeek($scheduleHelper->getStartDate($startDate)));
            $scheduledClass->setGxClass($class);
            $scheduledClass->addInstructor($instructor);
            if ($class != null && $instructor != null && $location != null) {


                $em = $this->getDoctrine()->getManager();
                $em->persist($scheduledClass);
                $em->flush();

                return $this->redirectToRoute('gx_scheduled_class_index');
            }

        }


        return $this->render('gx/scheduled_classes/new.html.twig', [
            'scheduledClass' => $scheduledClass,
            'errors' => $errors,
            'classShortNames' => $classHelper->getAllClassShortNames(),
            'instructors' => $userHelper->getAllUsersWithRole("ROLE_GX_INSTRUCTOR"),
            'locations' => $locationHelper->getLocationsNames(),
            'buffaloRooms' => $locationHelper->getRoomsForLocation("Buffalo"),
            'monticelloRooms' => $locationHelper->getRoomsForLocation("Monticello"),
            'zimmermanRooms' => $locationHelper->getRoomsForLocation("Zimmerman"),
        ]);
    }
}
