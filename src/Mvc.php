<?php

namespace XENONMC\XPFRAME\Mvc;
use XENONMC\XPFRAME\ext\Config;
use XENONMC\XPFRAME\ext\Utils;
use XENONMC\XPFRAME\Mvc\mvc\Controller;
use XENONMC\XPFRAME\Mvc\mvc\Model;
use XENONMC\XPFRAME\Mvc\mvc\View;

class Mvc {

    /**
     * @var View view class
     */
    public View $view;

    /**
     * @var Model model class
     */
    public Model $model;

    /**
     * @var Controller controller class
     */
    public Controller $controller;

    /**
     * options
     */
    public array $options = array(

        "v-cache-dir" => "internal/cache",
        "v-view-dir" => "internal/views"
    );

    /**
     * central class for performing mvc functions for displaying, rendering webpages, starting app classes, managing a databases and more
     *
     * @param array $options , all the options for constructing
     */
    function __construct(array $options = [])
    {

        // globally define the initialization options in this class
        $this->options = $options;

        // fill in options array
        $options = Utils::fill_array($this->options, $options);

        // initialize mvc class based on config
        foreach (Config::get("xpframe.yml")['mvc']['classes'] as $mvc_class_name) {

            // create mvc class namespace and construct it
            $mvc_class_namespace = "\\XENONMC\\XPFRAME\\Mvc\\mvc\\" . $mvc_class_name;
            $this->{$mvc_class_name} = new $mvc_class_namespace($this, $options);
        }
    } 
}
