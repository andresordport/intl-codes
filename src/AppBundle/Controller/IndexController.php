<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;
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
        /*
       \Locale::setDefault('en');
        $currencies = Intl::getCurrencyBundle()->getCurrencyNames();

        $currency = Intl::getCurrencyBundle()->getCurrencyName('INR');

        $symbol = Intl::getCurrencyBundle()->getCurrencySymbol('INR');

        $fractionDigits = Intl::getCurrencyBundle()->getFractionDigits('INR');

        $roundingIncrement = Intl::getCurrencyBundle()->getRoundingIncrement('INR');
        */
        /**
         * Con los numeros no lo consigo, xro con las fechas si
         */
//        echo("Y para numeros:<br>");
//        echo("En español 1234,567 son: <br>");
//        echo("En en_US:<br>");
//        $formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
//        echo $formatter->format(1234.567);
//        echo("En de_DE:<br>");
//        $formatter = new NumberFormatter('de_DE', NumberFormatter::CURRENCY);
//        echo $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);
//        echo("En es_ES:<br>");
//        $formatter = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
//        echo $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);
//        echo("En ja_JP:<br>");
//        $formatter = new NumberFormatter('ja_JP', NumberFormatter::CURRENCY);
//        echo $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);
        // replace this example code with whatever you need
        return $this->render('default/intl.html.twig');
    }
}
