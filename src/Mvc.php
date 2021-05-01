<?php

namespace XENONMC\XPFRAME\vendor\Mvc;

use XENONMC\XPFRAME\ext\Utils;
use XENONMC\XPFRAME\vendor\Mvc\mvc\Controller;
use XENONMC\XPFRAME\vendor\Mvc\mvc\Model;
use XENONMC\XPFRAME\vendor\Mvc\mvc\View;

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
        "v-cache-dir" => "internal/cache/views",
        "v-views-dir" => "internal/views",
        "use" => [],
        "use-on-cli-command-event" => true,
        "stop-apps-on-cli-run" => true,
        "c-apps-dir" => "src/apps"
    );

    /**
     * central class for performing mvc functions for displaying, rendering webpages, starting app classes, managing a databases and more
     *
     * @param array $options all the options for constructing
     * @param callable|null $callback callback function
     */
    function __construct(array $options = [], callable|null $callback = null)
    {
        // globally define the initialization options in this class
        $this->options = $options;

        // fill in options array
        $options = Utils::fill_array($this->options, $options);

        // initialize mvc class based on config
        if (in_array("Model", $options["use"])) {
            $this->model = new Model($this, $options);
        }
        if (in_array("View", $options["use"])) {
            $this->view = new View($this, $options);
        }
        if (in_array("Controller", $options["use"])) {
            $this->controller = new Controller($this, $options);
        }
        
        // run callback
        if ($callback != null) {
            $callback($this);
        }
    } 
}
