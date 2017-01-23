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
//        $kernel = $this->get('kernel');
//        $application = new Application($kernel);
//        $application->setAutoExit(false);
//
//        $input = new ArrayInput(array(
//            'command' => 'app:get-textTermDocumentMatrix'
//        ));
////        // You can use NullOutput() if you don't need the output
//        $output = new BufferedOutput();
////        $tmpFile = tmpfile();
////        $output  = new StreamOutput($tmpFile);
//        $application->run($input, $output);
////        fseek($tmpFile, 0);
////        $output = fread($tmpFile, 1024);
////        fclose($tmpFile);
//
//        $content = $output->fetch();
////        $content = $output;
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        // The input interface should contain the command name, and whatever arguments the command needs to run
        $input = new ArrayInput(array("app:get-textTermDocumentMatrix"));
        $output = new MemoryWriter();

        // Run the command
        $retval = $application->run($input, $output);
        if(!$retval)
        {
            echo "Command executed successfully!\n";
        }
        else
        {
            echo "Command was not successful.\n";
        }
        var_dump($output->getOutput());

        return $this->render('default/termDocumentMatrix.html.twig', ["data" => $content]);

    }

}
