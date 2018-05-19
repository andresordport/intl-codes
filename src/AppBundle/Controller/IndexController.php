<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Intl\DateFormatter\IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', []);
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
     * Para pasar parametros opcionales en symfony, se puede hacer de 2 formas:
     * 1º : Definiendo un valor por defecto
     * @Route("/secondHola/{id}", name="secondHola", defaults={"id" = ""})
     * o
     * 2º: Definiendo 2 rutas, una con el parametro y otra sin el
     * @Route("/secondHola", name="secondHolaWithParams")
     * @Route("/secondHola/{id}", name="secondHola")
     */

    /**
     * @Route("/secondHola/{id}", name="secondHolaWithParams", defaults={"id" = ""})
     */
    public function secondHolaAction(Request $request)
    {
        $secondHolaService = $this->container->get('SecondHolaService');
        $secondHolaService->secondHolaService();
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
        $b = new \NumberFormatter("ja_JP", \NumberFormatter::DECIMAL);
        echo $b->format(12345.12345) . "<br>"; // outputs 12.345,12
        $numero = $a->format(12345.12345);
        // replace this example code with whatever you need
        return $this->render('default/intl.html.twig', ["numero" => $numero]);
    }

    /**
     * @Route("/loteria", name="loteria")
     */
    public function loteriaAction(Request $request)
    {
        $service = $this->container->get('PrimitivaService');
        $numeros = $service->primitivaService();
        return $this->render('default/loteria.html.twig', ["numeros" => $numeros]);
    }

//    /**
//     * @Route("/loteriaCronJob", name="loteriaCronJob")
//     */
//    public function loteriaCronJobAction(Request $request)
//    {
//        $kernel = $this->get('kernel');
//        $application = new Application($kernel);
//        $application->setAutoExit(false);
//
//        $input = new ArrayInput(array(
//            'command' => 'app:get-webPrimitiva'
//        ));
//        // You can use NullOutput() if you don't need the output
//        $output = new BufferedOutput();
//        $application->run($input, $output);
//
//        // return the output, don't use if you used NullOutput()
//        $content = $output->fetch();
//
//        // return new Response(""), if you used NullOutput()
//        return new Response($content);
//
//    }

}
