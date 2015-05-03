<?php

/* CookbookBundle:recipe:preparation.html.twig */
class __TwigTemplate_49f42b5ae70e919e68c339a5206463c49d701742864f123bc19db69622a661bb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'preparation' => array($this, 'block_preparation'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('preparation', $context, $blocks);
    }

    public function block_preparation($context, array $blocks = array())
    {
        // line 2
        echo "    <h2>Preparation</h2>
    <p>
        You've adjusted the recipe from 4 Servings (as originally posted) to 4 Servings.
        The ingredients above reflect 4 Servings, but the instructions reflect the as-posted 4 Servings.
        You may need to adjust the times, temperatures or quantities mentioned in the recipe below as needed.
    </p>
    <p>
        Sift dry ingredients. Blend together egg yolks and yogurt, mix well;
        add to dry ingredients, add margarine and mix together lightly. Add blueberries.
        Fold in egg whites. Bake on hot griddle until golden on both sides.
    </p>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:recipe:preparation.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
