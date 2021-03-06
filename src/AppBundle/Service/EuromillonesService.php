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
use AppBundle\Entity\Euromillones;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class EuromillonesService extends ContainerAwareCommand
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
        $this->url = "http://www.loteriasyapuestas.es/es/euromillones";
        $this->em = $em;
    }

//    protected function execute(InputInterface $input, OutputInterface $output)
    public function euromillonesService()
    {
        $client = new Client();
        $crawler = $client->request('GET', $this->url);
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

        $bolaBD = new Euromillones();
        $bolaBD->setBola1($nodeValues[2]);
        $bolaBD->setBola2($nodeValues[3]);
        $bolaBD->setBola3($nodeValues[4]);
        $bolaBD->setBola4($nodeValues[5]);
        $bolaBD->setBola5($nodeValues[6]);
//        $date = date("Y-m-d", strtotime('-1 day'));
//        $bolaBD->setCreatedAt(new \DateTime($date));
        $nodeValues2 = $crawler->filter('.cuerpoRegionDerecha li')->each(function (Crawler $node) {
            return $node->text();
        });
        $bolaBD->setEstrella1($nodeValues2[0]);
        $bolaBD->setEstrella2($nodeValues2[1]);
        try {
            $this->em->persist($bolaBD);
            $this->em->flush();
            return [$nodeValues, $nodeValues2];
        } catch (UniqueConstraintViolationException $e) {
            return [$nodeValues, $nodeValues2, "Duplicate"];
        }
    }
}