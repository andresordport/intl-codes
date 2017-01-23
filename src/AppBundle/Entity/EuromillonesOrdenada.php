<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 28/10/16
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
//use Symfony\Component\Validator\Constraints as Assert;
//use AppBundle\Validator\Constraints as UserAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\UniqueConstraint;


///**
// * @ORM\Entity
// * @ORM\Table(name="evento", uniqueConstraints={@UniqueConstraint(name="evento_unique", columns={"name", "date"})})
// */

/**
 * @ORM\Entity
 * @ORM\Table(name="euromillonesOrdenada", uniqueConstraints={@UniqueConstraint(name="euromillones_unique", columns="created_at")})
 */
class EuromillonesOrdenada
{
    use TimestampableEntity;

    /**
     * @ORM\Id;
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bola1;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bola2;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bola3;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bola4;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bola5;

    /**
     * @ORM\Column(type="integer")
     */
    protected $estrella1;

    /**
     * @ORM\Column(type="integer")
     */
    protected $estrella2;

//    /**
//     * @Assert\Date()
//     * @ORM\Column(type="date")
//     */
//    protected $date;

    public function getId()
    {
        return $this->id;
    }

    public function setBola1($bola1)
    {
        $this->bola1 = $bola1;
    }

    public function getBola1()
    {
        return $this->bola1;
    }

    public function setBola2($bola2)
    {
        $this->bola2 = $bola2;
    }

    public function getBola2()
    {
        return $this->bola2;
    }

    public function setBola3($bola3)
    {
        $this->bola3 = $bola3;
    }

    public function getBola3()
    {
        return $this->bola3;
    }

    public function setBola4($bola4)
    {
        $this->bola4 = $bola4;
    }

    public function getBola4()
    {
        return $this->bola4;
    }

    public function setBola5($bola5)
    {
        $this->bola5 = $bola5;
    }

    public function getBola5()
    {
        return $this->bola5;
    }

    public function setEstrella1($estrella1)
    {
        $this->estrella1 = $estrella1;
    }

    public function getEstrella1()
    {
        return $this->estrella1;
    }

    public function setEstrella2($estrella2)
    {
        $this->estrella2 = $estrella2;
    }

    public function getEstrella2()
    {
        return $this->estrella2;
    }
}