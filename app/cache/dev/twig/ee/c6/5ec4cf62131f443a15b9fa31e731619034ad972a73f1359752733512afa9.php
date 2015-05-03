<?php

/* CookbookBundle:recipe:ingredients.html.twig */
class __TwigTemplate_eec65ec4cf62131f443a15b9fa31e731619034ad972a73f1359752733512afa9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'ingredients' => array($this, 'block_ingredients'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('ingredients', $context, $blocks);
    }

    public function block_ingredients($context, array $blocks = array())
    {
        // line 2
        echo "    <h2>Ingredients</h2>
    <ul>
        <li>414 ml Flour</li>
        <li>7 ml Sugar</li>
        <li>1 ml Baking Powder</li>
        <li>5 ml Baking Soda</li>
        <li>3 Egg yolks ; beaten</li>
        <li>3 Egg whites ; beaten stiff</li>
        <li>44 ml Margarine ; melted</li>
        <li>532 ml Low fat plain yogurt</li>
        <li>237 ml Blueberries</li>
    </ul>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:recipe:ingredients.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
