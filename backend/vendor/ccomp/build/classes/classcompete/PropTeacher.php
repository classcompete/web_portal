<?php


/**
 * Skeleton subclass for representing a row from the 'teachers' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.classcompete
 */
class PropTeacher extends BasePropTeacher
{

    public function getCreatedAt()
    {
        $db_time = parent::getCreated();
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff() * 60 * 60));
        return $new_time;
    }

    public function getUpdatedAt()
    {
        $db_time = parent::getModified();
        $new_time = date('m/d/Y h:i a', strtotime($db_time) - (-1 * AdminHelper::getTimezoneDiff() * 60 * 60));
        return $new_time;
    }

    public function getLicenseCount()
    {
        $teacherLicence = PropTeacherLicenseQuery::create()->findOneByTeacherId(self::getTeacherId());
        if (empty($teacherLicence) === true) {
            $count = 0;
        } else {
            $count = $teacherLicence->getCount();
        }

        return $count;
    }

    public function getAvailableLicenses()
    {
        $total = self::getLicenseCount();
        $occupied = self::getOccupiedLicenses();
        return $total - $occupied;
    }

    public function getOccupiedLicenses()
    {
        $classes = PropClasQuery::create()->filterByTeacherId(self::getTeacherId())->filterByLimit(2, Criteria::GREATER_THAN)->find();
        $occupied = 0;
        foreach ($classes as $class) {
            $occupied += $class->getLimit();
        }

        return $occupied;
    }

    public function getTotalPurchases()
    {
        $teachOrders = PropTeacherOrderQuery::create()
            ->filterByTeacherId(self::getTeacherId())
            ->filterByStatus(PropTeacherOrderPeer::STATUS_SUCCESS);
        $total = 0;
        if (empty($teachOrders) === false) {
            $total = $teachOrders->count();
        }
        return $total;
    }

    public function getTotalQuantity()
    {
        $teacherLicenses = PropTeacherLicenseQuery::create()->findOneByTeacherId(self::getTeacherId());
        $count = 0;
        if (empty($teacherLicenses) === false){
            $count = $teacherLicenses->getCount();
        }
        return $count;
    }

} // PropTeacher
