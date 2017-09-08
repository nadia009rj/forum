<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 08/09/2017
 * Time: 09:42
 */

namespace AppBundle\Service;


class HelloService
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var HelloRenderer
     */
    private $renderer;

    /**
     * HelloService constructor.
     * @param $name
     * @param HelloRenderer $renderer
     */
    public function __construct($name, HelloRenderer $renderer)
    {
        $this->name = $name;
        $this->renderer = $renderer;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function sayHello(){
        return $this->renderer->render("hello $this->name");

    }

}