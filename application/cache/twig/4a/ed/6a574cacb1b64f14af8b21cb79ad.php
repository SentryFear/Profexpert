<?php

/* users/add.html */
class __TwigTemplate_4aed6a574cacb1b64f14af8b21cb79ad extends Twig_Template
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
        $context["active"] = "ausr";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        if (isset($context["success"])) { $_success_ = $context["success"]; } else { $_success_ = null; }
        if ((twig_length_filter($this->env, $_success_) > 0)) {
            // line 5
            echo "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>";
            // line 7
            if (isset($context["success"])) { $_success_ = $context["success"]; } else { $_success_ = null; }
            echo twig_escape_filter($this->env, $_success_, "html", null, true);
            echo "</strong>
</div>
";
        }
        // line 10
        if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
        if ((twig_length_filter($this->env, $_error_) > 0)) {
            // line 11
            echo "<div class=\"alert alert-error\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <strong>";
            // line 13
            if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
            echo twig_escape_filter($this->env, $_error_, "html", null, true);
            echo "</strong>
</div>
";
        }
        // line 16
        echo "<form class=\"form-horizontal\" method=\"POST\">
  <div class=\"control-group\">
    <label class=\"control-label\" for=\"username\">Логин</label>
    <div class=\"controls\">
      <input type=\"text\" id=\"username\" name=\"username\" placeholder=\"Логин\">
    </div>
  </div>
  <div class=\"control-group\">
    <label class=\"control-label\" for=\"name\">ФИО</label>
    <div class=\"controls\">
      <input type=\"text\" id=\"name\" name=\"name\" placeholder=\"ФИО\">
    </div>
  </div>
  <div class=\"control-group\">
    <label class=\"control-label\" for=\"email\">Email</label>
    <div class=\"controls\">
      <input type=\"text\" id=\"email\" name=\"email\" placeholder=\"Email\">
    </div>
  </div>
  <div class=\"control-group\">
    <label class=\"control-label\" for=\"role\">Отдел</label>
    <div class=\"controls\">
      <input type=\"text\" id=\"role\" name=\"role\" placeholder=\"Отдел\">
    </div>
  </div>
  <div class=\"form-actions\">
    <input type=\"submit\" class=\"btn\" name=\"add\" value=\"Добавить\"/>
  </div>
</form>

";
    }

    public function getTemplateName()
    {
        return "users/add.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 16,  54 => 13,  50 => 11,  47 => 10,  40 => 7,  36 => 5,  33 => 4,  30 => 3,  25 => 2,);
    }
}
