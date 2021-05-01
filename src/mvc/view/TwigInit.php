<?php

namespace XENONMC\XPFRAME\vendor\Mvc\mvc\view;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigInit
{
    
    /**
     * @var Environment twig environment object
     */
    public $twig;
    
    /**
     * used for initializing twig to work with xpframe-mvc view class and the options array
     * 
     * @param array $options array of all the initialization options
     */
    public function __construct(array $options)
    {
        // initialize twig
        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
        $this->twig = new Environment($loader);
    }
    
    /**
     * get twig
     */
    public function get_twig(): Environment
    {
        // return the twig object
        return $this->twig;
    }
}