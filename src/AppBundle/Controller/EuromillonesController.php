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

class EuromillonesController extends Controller
{
    /**
     * @Route("/loteriaEuromillones", name="loteriaEuromillones")
     */
    public function loteriaEuromillonesAction(Request $request)
    {
        $service = $this->container->get('EuromillonesService');
        $numeros = $service->euromillonesService();
        return $this->render('default/loteriaEuromillones.html.twig', ["numeros" => $numeros]);
    }

//    /**
//     * @Route("/loteriaEuromillonesCronJob", name="loteriaEuromillonesCronJob")
//     */
//    public function loteriaEuromillonesCronJobAction(Request $request)
//    {
//        $kernel = $this->get('kernel');
//        $application = new Application($kernel);
//        $application->setAutoExit(false);
//
//        $input = new ArrayInput(array(
//            'command' => 'app:get-webEuromillones'
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
