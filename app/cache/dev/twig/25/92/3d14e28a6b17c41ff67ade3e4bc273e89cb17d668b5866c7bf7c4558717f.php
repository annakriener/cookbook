<?php

/* CookbookBundle:default:base.html.twig */
class __TwigTemplate_25923d14e28a6b17c41ff67ade3e4bc273e89cb17d668b5866c7bf7c4558717f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'main' => array($this, 'block_main'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\"/>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\">
        <title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

        <!-- STYLESHEET -->
        <link rel=\"stylesheet\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("css/styles.css"), "html", null, true);
        echo "\"/>
        ";
        // line 10
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 11
        echo "
        <!-- FAVICON -->
        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\"/>
    </head>

    <body>
        ";
        // line 17
        $this->env->loadTemplate("CookbookBundle:default:header.html.twig")->display($context);
        // line 18
        echo "        ";
        $this->env->loadTemplate("CookbookBundle:default:nav.html.twig")->display($context);
        // line 19
        echo "        ";
        $this->displayBlock('main', $context, $blocks);
        // line 22
        echo "        ";
        $this->env->loadTemplate("CookbookBundle:default:footer.html.twig")->display($context);
        // line 23
        echo "
        <!-- JAVASCRIPT -->
        <script src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("js/script.js"), "html", null, true);
        echo "\"></script>
        ";
        // line 26
        $this->displayBlock('javascripts', $context, $blocks);
        // line 27
        echo "    </body>
</html>
";
    }

    // line 6
    public function block_title($context, array $blocks = array())
    {
        echo "Welcome!";
    }

    // line 10
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 19
    public function block_main($context, array $blocks = array())
    {
        // line 20
        echo "            ";
        $this->env->loadTemplate("CookbookBundle:default:main.html.twig")->display($context);
        // line 21
        echo "        ";
    }

    // line 26
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "CookbookBundle:default:base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 26,  97 => 21,  94 => 20,  91 => 19,  86 => 10,  80 => 6,  74 => 27,  72 => 26,  68 => 25,  64 => 23,  61 => 22,  58 => 19,  55 => 18,  53 => 17,  46 => 13,  42 => 11,  40 => 10,  36 => 9,  30 => 6,  23 => 1,);
    }
}
