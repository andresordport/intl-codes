<?php
namespace AppBundle\Service;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Primitiva;
use AppBundle\Entity\PrimitivaOrdenada;

class TotalResultsService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function totalResultsService()
    {
        $repository = $this->em->getRepository('AppBundle:Primitiva');
        $repositoryOrdenada = $this->em->getRepository('AppBundle:PrimitivaOrdenada');

        $resultados = $repository->findBy([], ['createdAt' => 'ASC']);
        $resultadosOrdenada = $repositoryOrdenada->findBy([], ['createdAt' => 'ASC']);
        $array = array();
        $arrayRepeticiones = array();
        $arrayOrdenada = array();
        foreach ($resultados as $result) {
            /** Para cada bola, si ha salido alguna vez ese mismo numero sumamos una ocasión mas
             * [ 17 => 'value' => int 17, 'date' => int 2
             * 28 => 'value' => int 28, 'date' => int 4
             * 31 => 'value' => int 31, 'date' => int 3 ]
             */
            for ($i = 1; $i < 7; $i++) {
                $funget = "getBola$i";
                $pos = $result->$funget();
                if (isset($array[$pos]) && isset($array[$pos]) > 0) {
                    $array[$pos] = array("value" => $pos, "date" => $array[$pos]["date"] + 1);
                } else {
                    $array[$pos] = array("value" => $pos, "date" => 1);
                }
            }
            $pos = $result->getComplementario();
            if (isset($array[$pos]) && isset($array[$pos]) > 0) {
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
        return ["resultadosOrdenada" => $resultadosOrdenada,
            "arrayRepeticiones" => $arrayRepeticiones];
    }
}