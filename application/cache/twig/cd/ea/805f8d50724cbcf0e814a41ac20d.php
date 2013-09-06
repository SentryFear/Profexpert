<?php

/* request/upload.html */
class __TwigTemplate_cdea805f8d50724cbcf0e814a41ac20d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div id=\"upload\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-header\">
      <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
      <h3 id=\"myModalLabel\">Загрузить документы</h3>
    </div>
    <form method=\"POST\" enctype=\"multipart/form-data\" class=\"form-horizontal\">
      <input type=\"hidden\" name=\"id\" value=\"0\" id=\"ths\" />
      <div id=\"loading\" ";
        // line 8
        echo "><div class=\"loading\">&nbsp;</div></div>
      <div class=\"modal-body\" id=\"load\">
\t";
        // line 22
        echo "      </div>
      <div class=\"modal-footer\">
\t<div class=\"btn-group\">
\t  <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Закрыть</button>
\t  <input type=\"submit\" class=\"btn btn-primary\" name=\"upload\" value=\"Загрузить\" />
\t</div>
      </div>
    </form>
  </div>";
    }

    public function getTemplateName()
    {
        return "request/upload.html";
    }

    public function getDebugInfo()
    {
        return array (  32 => 22,  28 => 8,  19 => 1,);
    }
}
