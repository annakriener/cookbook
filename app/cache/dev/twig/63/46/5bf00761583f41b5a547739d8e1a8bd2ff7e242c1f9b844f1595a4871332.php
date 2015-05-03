<?php

/* CookbookBundle:recipe:recipe.html.twig */
class __TwigTemplate_63465bf00761583f41b5a547739d8e1a8bd2ff7e242c1f9b844f1595a4871332 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("CookbookBundle:default:base.html.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'main' => array($this, 'block_main'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "CookbookBundle:default:base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_main($context, array $blocks = array())
    {
        // line 4
        echo "    <main>
        <div class=\"container cb-recipe\">
            <div class=\"row\">
                <div class=\"col-md-3\">
                    <img class=\"cb-recipe-image\" src=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/pancakes.jpg"), "html", null, true);
        echo "\" alt=\"pancakes\" title=\"Pancakes\">
                </div>
                <div class=\"col-md-9\">
                    ";
        // line 11
        $this->env->loadTemplate("CookbookBundle:recipe:recipe-info.html.twig")->display($context);
        // line 12
        echo "                </div>
            </div>

            <div class=\"row\">
                <div class=\"col-md-4\">
                    ";
        // line 17
        $this->env->loadTemplate("CookbookBundle:recipe:ingredients.html.twig")->display($context);
        // line 18
        echo "                </div>
                <div class=\"col-md-8\">
                    ";
        // line 20
        $this->env->loadTemplate("CookbookBundle:recipe:preparation.html.twig")->display($context);
        // line 21
        echo "                </div>
            </div>

        </div>
    </main>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:recipe:recipe.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 21,  66 => 20,  62 => 18,  60 => 17,  53 => 12,  51 => 11,  45 => 8,  39 => 4,  36 => 3,  11 => 1,);
    }
}
