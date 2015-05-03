<?php

/* CookbookBundle:default:footer.html.twig */
class __TwigTemplate_a5abd235272257a19c5c5fb5911220c6cd84552fb1d48b723ffc27b4964e53a9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('footer', $context, $blocks);
    }

    public function block_footer($context, array $blocks = array())
    {
        // line 2
        echo "    <footer class=\"container-fluid\">
        <div class=\"row cb-footer\">
        <p>Cookbook by Tina Schuh & Anna Kriener</p>
        </div>
    </footer>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:default:footer.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
