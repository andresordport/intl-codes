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
use AppBundle\Entity\Primitiva;
use AppBundle\Entity\PrimitivaOrdenada;

class PrimitivaController extends Controller
{
    /**
     * @Route("/loteriaPrimitiva", name="loteriaPrimitiva")
     */
    public function loteriaPrimitivaAction(Request $request)
    {
        $service = $this->container->get('PrimitivaService');
        $numeros = $service->primitivaService();
        return $this->render('default/loteriaPrimitiva.html.twig', ["numeros" => $numeros]);
    }

    /**
     * @Route("/resultadosLoteriaPrimitiva", name="resultadosLoteriaPrimitiva")
     */
    public function resultadosLoteriaPrimitiva(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
        $totalResultsService = $this->container->get('TotalResultsService');
        $totalPerMonthService = $this->container->get('TotalPerMonthService');
        $resultadosTotalResults = $totalResultsService->totalResultsService();
        $resultadosTotalPerMonth = $totalPerMonthService->totalPerMonthService();
//        $month = date_format(new \Datetime('now'),'Y/m');
//        $primero = $resultadosTotalPerMonth[$month];
//        $month1 = new \Datetime('now');
//        $month1 = $month1->modify('-1 month');
//        $monthF = date_format($month1,'Y/m');
//        $segundo = $resultadosTotalPerMonth[$monthF];
//        $month1 = $month1->modify('-1 month');
//        $monthF = date_format($month1,'Y/m');
//        $tercero = $resultadosTotalPerMonth[$monthF];
//        var_dump(json_encode($resultadosTotalResults["arrayRepeticiones"]));
//        var_dump(json_encode($primero));
//        die();
        return $this->render('default/resultadosLoteriaPrimitiva.html.twig', [
            /*"resultadosOrdenada" => $resultadosTotalResults["resultadosOrdenada"],*/
            "arrayRepeticiones" => json_encode($resultadosTotalResults["arrayRepeticiones"]),
            "arrayPorMes1" => json_encode($resultadosTotalPerMonth["arrayRepeticionesPrimero"]),
            "arrayPorMes2" => json_encode($resultadosTotalPerMonth["arrayRepeticionesSegundo"]),
            "arrayPorMes3" => json_encode($resultadosTotalPerMonth["arrayRepeticionesTercero"])
        ]);
    }
//    /**
//     * @Route("/loteriaPrimitivaCronJob", name="loteriaPrimitivaCronJob")
//     */
//    public function loteriaPrimitivaCronJobAction(Request $request)
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
