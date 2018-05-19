<?php

namespace AppBundle\Service;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\HolaService;


class SecondHolaService // extends Controller
{
    public $injectedService;

    public function __construct(HolaService $service){
        $this->injectedService = $service;
    }

    public function secondHolaService()
    {
        $this->injectedService->holaService();
    }
}
