<?php
namespace AppBundle\Service;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use DOMDocument;
use DOMXPath;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Primitiva;
use AppBundle\Entity\PrimitivaOrdenada;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class PrimitivaService extends ContainerAwareCommand
{
    protected $em;
    protected $url;

//    protected function configure()
//    {
//        $this
//            // the name of the command (the part after "bin/console")
//            ->setName('app:get-websitphpe')
//            // the short description shown while running "php bin/console list"
//            ->setDescription('Scraps a website.')
//            // the full command description shown when running the command with
//            // the "--help" option
//            ->setHelp("This command allows you scrap a website");
//    }

    public function __construct(EntityManager $em)
    {
        $this->url = "http://www.loteriasyapuestas.es/es/la-primitiva";
        $this->em = $em;
    }

//    protected function execute(InputInterface $input, OutputInterface $output)
    public function primitivaService()
    {
        $client = new Client();
        $crawler = $client->request('GET', $this->url);
        $crawler2 = $crawler;
        $nodeValues2 = $crawler->filter('.cuerpoRegionIzq')->each(function (Crawler $node) {
            return $node->text();
        });
        $nodeValues = explode(" ", $nodeValues2[0]);
//        /** Uso unset aunque no reordene el array */
//        unset($nodeValues[0]);
//        unset($nodeValues[1]);
//        var_dump($nodeValues);
//        foreach($nodeValues as $num=>$bola){
//            echo($num."=>".$bola."<br>");
//        };
//        die();

        $bolaBD = new Primitiva();
        $bolaBD->setBola1($nodeValues[2]);
        $bolaBD->setBola2($nodeValues[3]);
        $bolaBD->setBola3($nodeValues[4]);
        $bolaBD->setBola4($nodeValues[5]);
        $bolaBD->setBola5($nodeValues[6]);
        $bolaBD->setBola6($nodeValues[7]);
        $date = date("Y-m-d", strtotime('-1 day'));
        $bolaBD->setCreatedAt(new \DateTime($date));
        $nodeValues2 = $crawler->filter('.cuerpoRegionDerecha span')->each(function (Crawler $node) {
            return $node->text();
        });
        $bolaBD->setComplementario($nodeValues2[0]);
        $bolaBD->setReintegro($nodeValues2[1]);
        try {
            $this->em->persist($bolaBD);
//            $this->em->flush();
            $orderedNodeValues2 = $nodeValues2;
            $orderedNodeValues = $nodeValues;
            /** ahora cojemos las bolas ordenadas */
            /** primero pulsamos sobre "más información" */
            //select a link
            $link = $crawler2->filter('div.masInfo > a')->link();
            //click to follow link
            $crawler2 = $client->click($link);
            /** despues pulsamos sobre "ver por orden de aparición" */
            //select a link
            $link = $crawler2->filter('div.cuerpoRegion div.resultadoAnterior > a')->link();
            //click to follow link
            $crawler2 = $client->click($link);
            $nodeValues2 = $crawler2->filter('#actMainNumbers')->each(function (Crawler $node) {
                return $node->text();
            });
            $nodeValues = explode("\n", $nodeValues2[0]);
            $bolaBD2 = new PrimitivaOrdenada();
            $bolaBD2->setBola1($nodeValues[0]);
            $bolaBD2->setBola2($nodeValues[1]);
            $bolaBD2->setBola3($nodeValues[2]);
            $bolaBD2->setBola4($nodeValues[3]);
            $bolaBD2->setBola5($nodeValues[4]);
            $bolaBD2->setBola6($nodeValues[5]);
            $bolaBD2->setCreatedAt(new \DateTime($date));
            $nodeValues2[0] = $crawler2->filter('.cuerpoRegionMed span')->each(function (Crawler $node) {
                return $node->text();
            });
            $nodeValues2[1] = $crawler2->filter('.cuerpoRegionDerecha span')->each(function (Crawler $node) {
                return $node->text();
            });
            $bolaBD2->setComplementario($nodeValues2[0][0]);
            $bolaBD2->setReintegro($nodeValues2[1][0]);
            $this->em->persist($bolaBD2);
            $this->em->flush();
            return [$orderedNodeValues, $orderedNodeValues2, $nodeValues, $nodeValues2];
        } catch (UniqueConstraintViolationException $e) {
            return ["Duplicate"];
        }
    }
}