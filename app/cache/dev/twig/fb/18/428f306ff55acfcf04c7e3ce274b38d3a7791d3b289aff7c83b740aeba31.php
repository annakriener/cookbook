<?php

/* CookbookBundle:default:box.html.twig */
class __TwigTemplate_fb18428f306ff55acfcf04c7e3ce274b38d3a7791d3b289aff7c83b740aeba31 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'box' => array($this, 'block_box'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('box', $context, $blocks);
    }

    public function block_box($context, array $blocks = array())
    {
        // line 2
        echo "    <section class=\"cb-box\">
          Test-Recipe
    </section>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:default:box.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
