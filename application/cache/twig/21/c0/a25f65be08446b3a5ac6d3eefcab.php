<?php

/* request/edit.html */
class __TwigTemplate_21c0a25f65be08446b3a5ac6d3eefcab extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("_main.html");

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "_main.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        $context["active"] = "req";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "  ";
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo $_result_;
        echo "

  <!-- Modal Add -->
    ";
        // line 8
        echo "  <!-- EndModal Add -->
  
";
    }

    public function getTemplateName()
    {
        return "request/edit.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 8,  33 => 4,  30 => 3,  25 => 2,);
    }
}
