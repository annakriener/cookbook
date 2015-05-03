<?php

/* CookbookBundle:recipe:recipe-info.html.twig */
class __TwigTemplate_dc07a5f352e7b72d43af54cd464a39d4feee519adc739cf157c43acba0d1b9f8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'recipeinfo' => array($this, 'block_recipeinfo'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('recipeinfo', $context, $blocks);
    }

    public function block_recipeinfo($context, array $blocks = array())
    {
        // line 2
        echo "    <section>
        <p>Author Name</p>
        <h1>Blueberry Yogurt Pancakes</h1>
        <p>Ready in 20 minutes</p>
        <p>serves 4</p>
    </section>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:recipe:recipe-info.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
