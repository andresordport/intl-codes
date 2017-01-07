<?php

namespace AppBundle\Service;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HolaService // extends Controller
{

    public function holaService()
    {
        // replace this example code with whatever you need
        var_dump("hola desde el service");die();
    }
}
