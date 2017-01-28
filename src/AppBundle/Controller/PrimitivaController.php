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
        $repository = $this->getDoctrine()->getRepository('AppBundle:Primitiva');
        $repositoryOrdenada = $this->getDoctrine()->getRepository('AppBundle:PrimitivaOrdenada');

        $resultados = $repository->findBy([], ['createdAt' => 'ASC']);
        $resultadosOrdenada = $repositoryOrdenada->findBy([], ['createdAt' => 'ASC']);
        $array = array();
        $arrayRepeticiones = array();
        $arrayOrdenada = array();
        foreach ($resultados as $result) {
            /** Para cada bola, si ha salido alguna vez ese mismo numero sumamos una ocasión mas */
            for ($i = 1; $i < 7; $i++) {
                $funget = "getBola$i";
                $pos = $result->$funget();
                if (isset($array[$pos]) && isset($array[$pos]) >0) {
                    $array[$pos] = array("value" => $pos, "date" => $array[$pos]["date"]+1);
                } else {
                    $array[$pos] = array("value" => $pos, "date" => 1);
                }
            }
            $pos = $result->getComplementario();
            if (isset($array[$pos]) && isset($array[$pos]) >0) {
                $array[$pos] = array("value" => $pos, "date" => $array[$pos]["date"] + 1);
            } else {
                $array[$pos] = array("value" => $pos, "date" => 1);
            }
        }
        sort($array);
        foreach ($array as $result) {
            $arrayRepeticiones[] = $result;
        }
//        var_dump(($array));
//        die();
        return $this->render('default/resultadosLoteriaPrimitiva.html.twig', ["resultados" => $resultados,
            "resultadosOrdenada" => $resultadosOrdenada, "arrayRepeticiones" => json_encode($arrayRepeticiones)]);
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
