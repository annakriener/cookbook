<?php

/* CookbookBundle:default:nav.html.twig */
class __TwigTemplate_78fd4cf788361806dd766aab14e8b3a98b56f6f9451bd8178d6b772eace54a2c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'nav' => array($this, 'block_nav'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('nav', $context, $blocks);
    }

    public function block_nav($context, array $blocks = array())
    {
        // line 2
        echo "    <div class=\"container\">
        <div class=\"row cb-nav\">
            <div class=\"col-md-4\">
                <nav>
                    <a class=\"btn btn-default\" href=\"#\" role=\"button\">Home</a>
                    <a class=\"btn btn-default\" href=\"#\" role=\"button\">Breakfast</a>
                    <a class=\"btn btn-default\" href=\"#\" role=\"button\">Lunch</a>
                    <a class=\"btn btn-default\" href=\"#\" role=\"button\">Dinner</a>
                </nav>
            </div>
        </div>
    </div>
    <hr>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:default:nav.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
