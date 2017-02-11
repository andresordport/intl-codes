<?php
namespace AppBundle\Command;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

//
//use Symfony\Component\Finder\Finder;

class notUsedGetTermDocumentMatrixCommand extends ContainerAwareCommand
{
    protected $em;
    protected $contador = false;
    protected $contador2 = false;

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:get-notUsedTextTermDocumentMatrix')
            // the short description shown while running "php bin/console list"
            ->setDescription('Gets the Term Document Matrix from an introduced text.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you get the Term Document Matrix from an introduced text.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $finder = new Finder();
//        $finder->files()->in($this->getContainer()->get('kernel')->getRootDir()."/../web/Rfiles/ejemplo.R");
//
//        foreach ($finder as $file) {
//            // Dump the absolute path
//            var_dump($file->getRealPath());
//
//            // Dump the relative path to the file, omitting the filename
//            var_dump($file->getRelativePath());
//
//            // Dump the relative path to the file
//            var_dump($file->getRelativePathname());
//        }
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $process = new Process("R < " . $this->getContainer()->get('kernel')->getRootDir() . '/../web/Rfiles/ejemplo.R' . " este es el texto de prueba para el text mining --no-save");
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        };
        $arrayData = [];
        $texto = $process->getOutput();
        if ($output) {
            foreach (preg_split("/((\r?\n)|(\r\n?))/", $texto) as $line) {
                /**
                 * Cambiamos el contador2 despues de haber ejecutado lo que debemos hacer cuando == "W" para hacerlo un ciclo despues
                 * y así pasar de linea
                 */
                if ($this->contador2 == true) {
                    if (isset($line[0]) && $line[0] != ">") {
//                        echo($line."<br>");
                        $array = [];
                        foreach (explode(" ", $line) as $a) {
                            if ($a != "") {
                                $array[] = $a;
//                                echo($a . "<br>");
                            }
                        }
                        $arrayData[] = array('value' => $array[0], 'date' => $array[1]);
//                        $arrayData[] = json_encode($arrayData);
                        /** <-- funciona esta y el foreach de abajo */
//                        var_dump($arrayData);
//                        foreach ($arrayData as $array) {
//                            echo($array['value']."\n".$array['date']."\n");
//                        }
                    }
                }
                /** Saltamos lineas de "Docs" y "Terms 1" */
                if ($this->contador == true) {
                    if (explode(" ", $line)[0] == "Terms") {
//                        echo($line);
                        $this->contador2 = true;
                    }
                }
                /** Hasta llegar a la linea "Weighting" */
                if (isset($line[0]) && $line[0] != "W") {
                } else {
                    /**
                     * Cambiamos el contador despues de haber ejecutado lo que debemos hacer cuando == "W" para hacerlo un ciclo despues
                     * y así pasar de linea
                     */
//                    echo("Weighting es: ".$line[0].$line[1].$line[2].$line[3].$line[4].$line[5].$line[6].$line[7].$line[8]);
                    $this->contador = true;
                }
//                echo($line."<br>");
            }
//            echo(($texto));
        }
        foreach ($arrayData as $array) {
//            echo($array['value'] . "\n" . $array['date'] . "\n");
            $output->writeln(array($array['value']." ".$array['date']));
//            $output->writeln('');
//            $output->writeln($array['date']);
        }
//        $output->writeln("Only running pre-hooks");
        return $arrayData;
    }
}