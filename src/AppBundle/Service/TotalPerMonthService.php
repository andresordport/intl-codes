<?php
namespace AppBundle\Service;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Primitiva;
use AppBundle\Entity\PrimitivaOrdenada;
use Doctrine\ORM\Query\ResultSetMapping;

class TotalPerMonthService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function totalPerMonthService()
    {
        $repository = $this->em->getRepository('AppBundle:Primitiva');

        $resultados = $repository->findBy([], ['createdAt' => 'DESC']);
        $array = array();
        $arrayRepeticionesPrimero = array();
        $arrayRepeticionesSegundo = array();
        $arrayRepeticionesTercero = array();
        foreach ($resultados as $result) {
            /** Para cada bola, si ha salido alguna vez ese mismo numero sumamos una ocasión mas
            '2016/12' => 17 => 'value' => int 17, 'date' => int 1
                         28 => 'value' => int 28, 'date' => int 2
                         31 => 'value' => int 31, 'date' => int 2
                         39 => 'value' => int 39, 'date' => int 1
            '2017/01' => 3 =>  'value' => int 3, 'date' => int 2
                         9 =>  'value' => int 9, 'date' => int 2
                         12 => 'value' => int 12, 'date' => int 2
             */
            $date = $result->getCreatedAt();
            $date = date_format($date, 'Y/m');
            for ($i = 1; $i < 7; $i++) {
                $funget = "getBola$i";
                $pos = $result->$funget();
                if (isset($array[$date][$pos]) && isset($array[$date][$pos]) > 0) {
                    $array[$date][$pos] = array("value" => $pos, "date" => $array[$date][$pos]["date"] + 1);
                } else {
                    $array[$date][$pos] = array("value" => $pos, "date" => 1);
                }
                sort($array[$date]);
            }
            $pos = $result->getComplementario();
            if (isset($array[$date][$pos]) && isset($array[$date][$pos]) > 0) {
                $array[$date][$pos] = array("value" => $pos, "date" => $array[$date][$pos]["date"] + 1);
            } else {
                $array[$date][$pos] = array("value" => $pos, "date" => 1);
            }
        }
        $month = date_format(new \Datetime('now'),'Y/m');
        $primero = $array[$month];
        foreach ($primero as $result) {
                $arrayRepeticionesPrimero[] = $result;
        }
        $month1 = new \Datetime('now');
        $month1 = $month1->modify('-1 month');
        $monthF = date_format($month1,'Y/m');
        $segundo = $array[$monthF];
        foreach ($segundo as $result) {
            $arrayRepeticionesSegundo[] = $result;
        }
        $month1 = $month1->modify('-1 month');
        $monthF = date_format($month1,'Y/m');
        $tercero = $array[$monthF];
        foreach ($tercero as $result) {
            $arrayRepeticionesTercero[] = $result;
        }
        return ["arrayRepeticionesPrimero" => $arrayRepeticionesPrimero, "arrayRepeticionesSegundo" => $arrayRepeticionesSegundo,
                "arrayRepeticionesTercero" => $arrayRepeticionesTercero];
    }
}