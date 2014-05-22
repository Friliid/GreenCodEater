<?php

/* GCENewsBundle:Rubriques:detail.html.twig */
class __TwigTemplate_bef45756e592baeae0b5628d70b37b3715c91cb0a5f78d2c00362fe969f1b889 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("base.html.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_title($context, array $blocks = array())
    {
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["rubrique"]) ? $context["rubrique"] : $this->getContext($context, "rubrique")), "nom"), "html", null, true);
        echo " ";
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
        // line 7
        echo "<article class=\"rub\">

    <div class=\"heading\">
    
        <h2><a href=\"#\">";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["rubrique"]) ? $context["rubrique"] : $this->getContext($context, "rubrique")), "nom"), "html", null, true);
        echo "</a></h2>
    
    </div>
    <div class=\"content\">
        <p>";
        // line 15
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["rubrique"]) ? $context["rubrique"] : $this->getContext($context, "rubrique")), "Description"), "html", null, true);
        echo "</p>
        
    </div>

</article>

";
    }

    public function getTemplateName()
    {
        return "GCENewsBundle:Rubriques:detail.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 15,  46 => 11,  40 => 7,  37 => 6,  29 => 4,);
    }
}
