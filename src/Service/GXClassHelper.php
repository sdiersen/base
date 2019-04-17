<?php
/**
 * Created by PhpStorm.
 * User: cippio
 * Date: 2/22/19
 * Time: 7:53 AM
 */

namespace App\Service;


use App\Entity\Gx\GxClass;
use App\Repository\Gx\GxClassRepository;

class GXClassHelper
{
    /**
     * @var GxClassRepository
     */
    private $gxClassRepository;

    public function __construct(GxClassRepository $gxClassRepository)
    {
        $this->gxClassRepository = $gxClassRepository;
    }

    public function getAllClassLongNames(): array
    {
        $ret = [];
        $longNames = $this->gxClassRepository->getAllLongClassNames();

        foreach($longNames as $name) {
            $ret[] = $name["name"];
        }
        return $ret;
    }

    public function getAllClassShortNames(): array
    {
        $ret = [];
        $shortNames = $this->gxClassRepository->getAllShortClassNames();

        foreach($shortNames as $name){
            $ret[] = $name["shortName"];
        }
        return $ret;
    }

    public function getClassFromShortName(?string $shortName): ?GxClass
    {
        if($shortName == null) return null;

        return $this->gxClassRepository->findOneByShortName($shortName);
    }
}
