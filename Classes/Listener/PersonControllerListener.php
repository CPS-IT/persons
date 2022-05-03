<?php


namespace CPSIT\Persons\Listener;

use CPSIT\Persons\Event\PersonsHandleFilterBeforeAssignEvent;
use CPSIT\Persons\Event\PersonsHandleListBeforeAssignEvent;

class PersonControllerListener
{
    /**
     * @param PersonsHandleFilterBeforeAssignEvent $params
     */
    public function handleFilterBeforeAssign(PersonsHandleFilterBeforeAssignEvent $params): void
    {

    }

    /**
     * @param PersonsHandleListBeforeAssignEvent $params
     */
    public function handleListBeforeAssign(PersonsHandleListBeforeAssignEvent $params): void
    {

    }
}