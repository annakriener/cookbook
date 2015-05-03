<?php

/* CookbookBundle:default:header.html.twig */
class __TwigTemplate_119a239108436eb148a830a3d121eb277a223c94fe4125700c1fce0c8e15fe58 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'header' => array($this, 'block_header'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('header', $context, $blocks);
    }

    public function block_header($context, array $blocks = array())
    {
        // line 2
        echo "    <header class=\"container-fluid\">
        <div class=\"row cb-header\">
            <div class=\"col-lg-3 col-md-3\">

                <img class=\"cb-logo\" src=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/logo.png"), "html", null, true);
        echo "\" title=\"Logo\" alt=\"Logo\" width=\"75px\">
                <h1 class=\"cb-h1\" id=\"cb-anna\">Cookbook</h1>
            </div>
            <div class=\"col-lg-3 col-lg-push-6\">
                <div class=\"cb-header-links\">
                    <button onclick=\"foo()\" class=\"btn btn-default\"><img src=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/cookbook.png"), "html", null, true);
        echo "\" width=\"20\"></button>
                    <button class=\"btn btn-default\"><img src=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("img/calender.png"), "html", null, true);
        echo "\" width=\"20\"></button>
                    <button class=\"btn btn-default\">Login</button>
                </div>
            </div>
        </div>
    </header>
    <hr>
";
    }

    public function getTemplateName()
    {
        return "CookbookBundle:default:header.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  44 => 12,  40 => 11,  32 => 6,  26 => 2,  20 => 1,);
    }
}
