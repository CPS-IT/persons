<?php

namespace CPSIT\Persons\Event;

use CPSIT\Persons\Controller\PersonController;

abstract class AbstractPersonEvent
{
    private PersonController $controller;
    private array $data;

    /**
     * @param PersonController $controller
     * @param array $data
     */
    public function __construct(PersonController $controller, array $data)
    {
        $this->controller = $controller;
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getController(): PersonController
    {
        return $this->controller;
    }
}