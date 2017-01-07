<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;

class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/hola", name="hola")
     */
    public function holaAction(Request $request)
    {
        $holaService = $this->container->get('HolaService');
        $holaService->holaService();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/intl", name="intl")
     */
    public function intlAction(Request $request)
    {
        echo("En es_ES:<br>");
        $a = new \NumberFormatter("es_ES", \NumberFormatter::DECIMAL);
        echo $a->format(12345.12345) . "<br>"; // outputs 12.345,12
        echo("En ja_JP:<br>");
        $a = new \NumberFormatter("ja_JP", \NumberFormatter::DECIMAL);
        echo $a->format(12345.12345) . "<br>"; // outputs 12.345,12
        // replace this example code with whatever you need
        return $this->render('default/intl.html.twig');
    }
}
