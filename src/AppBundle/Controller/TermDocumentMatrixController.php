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
use Symfony\Component\Console\Output\StreamOutput;

class TermDocumentMatrixController extends Controller
{
//    /**
//     * @Route("/loteriaPrimitiva", name="loteriaPrimitiva")
//     */
//    public function loteriaPrimitivaAction(Request $request)
//    {
//        $service = $this->container->get('PrimitivaService');
//        $numeros = $service->primitivaService();
//        return $this->render('default/loteriaPrimitiva.html.twig', ["numeros" => $numeros]);
//    }

    /**
     * @Route("/termDocumentMatrixCronJob", name="termDocumentMatrixCronJob")
     */
    public function termDocumentMatrixCronJobAction(Request $request)
    {
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array(
            'command' => 'app:get-textTermDocumentMatrix'
        ));
//        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();
        echo("Este es el contenido de 'R command' para la frase: 'este es el texto de prueba para el text mining'");
        $explodedArray = explode("\n",$content);
        $keyValArray = array();

        /**
         * la última posición del array es:
         * array (size=1)
         *   0 => string ''
         *
         */
        unset($explodedArray[count($explodedArray)-1]);
        foreach($explodedArray as $array){
            $explodedString = explode(" ",$array);
            $keyValArray[] = array("value" => $explodedString[0], "date" => $explodedString[1]);
        }
        $content = json_encode($keyValArray);

        return $this->render('default/termDocumentMatrix.html.twig', ["data" => $content]);

    }

}
