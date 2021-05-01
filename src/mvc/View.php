<?php

namespace XENONMC\XPFRAME\vendor\Mvc\mvc;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\SyntaxError;
use XENONMC\XPFRAME\vendor\Mvc\mvc\view\cache;
use XENONMC\XPFRAME\vendor\Mvc\mvc\view\TwigInit;
use XENONMC\XPFRAME\vendor\Mvc\Mvc;

class View
{

    /**
     * @var Mvc mvc class object
     */
    public Mvc $mvc;

    /**
     * @var Environment twig object
     */
    public Environment $twig;

    /**
     * @var array options used for initialization
     */
    public array $options;

    /**
     * cache functions
     */
    use cache;

    /**
     * controller class for mvc containing important functions to start stop and more for an application's class
     *
     * @param Mvc $mvc mvc class object
     * @param array $options array of all initialization options
     */
    public function __construct(Mvc $mvc, array $options)
    {
        // store mvc class object and options
        $this->mvc = $mvc;
        $this->options = $options;

        // create storage dirs
        if (!file_exists($options["v-cache-dir"])) {
            mkdir($options["v-cache-dir"], 0777, true);
        }
        if (!file_exists($options['v-views-dir'])) {
            mkdir($options["v-views-dir"], 0777, true);
        }

        // initialize twig with initializer
        $twig_init = new TwigInit($options);
        $this->twig = $twig_init->get_twig();
    }

    /**
     * compile a template
     *
     * @param string $group name of the group to get template from
     * @param string $template name of the template to compile
     * @param bool $isLayout is the template a layout template
     * @return string php template
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function compile(string $template, string $group, bool $isLayout): string
    {

        // get the template path
        $template_type_name = "templates";
        if ($isLayout == true) {
            $template_type_name = "layouts";
        }
        $template_path = $this->options["v-views-dir"] . "/" . $group . "/" . $template_type_name . "/" . $template . ".twig";

        // compile template to php code
        return $this->twig->compileSource($this->twig->getLoader()->getSourceContext($template_path));
    }

    /**
     * get a rendered template
     *
     * @param string $template name of the template to render
     * @param string $group group name of were the template is located
     * @param bool $isLayout is the template a layout template
     * @param bool $fromCache get the template from cache
     * @return string executed template string
     */
    public function get_rendered_template(string $template, string $group, bool $isLayout = false, bool $fromCache = true): string
    {
        // get the template
        $template_type_dir = "templates";
        if ($isLayout == true) {
            $template_type_dir = "layouts";
        }
        if ($fromCache == true) {
            // execute and return the the template
            $template = file_get_contents($this->options["v-cache-dir"] . "/" . $group . "/" . $template_type_dir . "/" . $template . ".php");
            eval("?>" . $template);

            preg_match("~class (.+?) ~", $template, $template_class);
            $template_class = $template_class[1];
            $template = new $template_class($this->twig);
            return $template->render([]);
        }

        // compile and return the template
        try {
            $template = $this->compile($template, $group, $isLayout);
        } catch (LoaderError | SyntaxError $e) {
            echo $e;
        }
        eval("?>" . $template);
        preg_match("~class (.+?) ~", $template, $template_class);
        $template_class = $template_class[1];
        $template = new $template_class($this->twig);
        return $template->render([]);
    }

    /**
     * render a layout and view together
     *
     * @param string $view view to use when rendering
     * @param string $layout layout to render view inside of
     * @param string $group group to render layout and view from
     * @param bool $fromCache render templates from cache
     */
    public function render(string $view, string $layout, string $group, bool $fromCache = true)
    {
        // get templates
        $layout = $this->get_rendered_template($layout, $group, true, $fromCache);
        $view = $this->get_rendered_template($view, $group, false, $fromCache);

        // insert view into layout and display
        $page = str_replace("(%>view<%)", $view, $layout);
        echo $page;
    }
}
