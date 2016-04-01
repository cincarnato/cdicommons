<?php

namespace CdiCommons\Entity;

use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Proxy\Proxy;
use Gedmo\Mapping\Annotation as Gedmo;
use Zend\InputFilter\InputFilter;
use Zend\Form\Annotation;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="cdi_schedule")
 *
 * @author Cristian Incarnato
 */
class Schedule extends \CdiCommons\Entity\AbstractEntity {

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    protected $id;

    /**
     * @var string
     * @Annotation\Type("Zend\Form\Element\Text")
     * @Annotation\Options({"label":"Nombre:"})
     * @Annotation\Validator({"name":"StringLength", "options":{"min":1, "max":25}})
     * @ORM\Column(type="string", length=25, unique=false, nullable=true)
     */
    protected $name;

    /**
     * @var 
     * @ORM\OneToMany(targetEntity="CdiCommons\Entity\Schedule", mappedBy="calendar")
     */
    protected $schedule;

    public function __construct() {
        $this->schedule = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSchedule() {
        return $this->schedule;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSchedule($schedule) {
        $this->schedule = $schedule;
    }

    function addSchedule(\CdiCommons\Entity\Schedule $schedule) {
        $this->schedule[] = $schedule;
    }

}
