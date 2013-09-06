<?php

/* card/view.html */
class __TwigTemplate_bdaea8d2ddbbbc54a0d6054fd2c9aa79 extends Twig_Template
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
        $context["active"] = "card";
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
        echo "ФИО - ";
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "fname"), "html", null, true);
        echo "<br>
Телефон - ";
        // line 17
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "phone"), "html", null, true);
        echo "<br>
Email - ";
        // line 18
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "email"), "html", null, true);
        echo "<br>
Район - ";
        // line 19
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "region"), "html", null, true);
        echo "<br>
Адрес - ";
        // line 20
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "address"), "html", null, true);
        echo "<br>
Тип помещения - ";
        // line 21
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "ptype"), "html", null, true);
        echo "<br>
Тип работ - ";
        // line 22
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "rtype"), "html", null, true);
        echo "<br>
Метраж - ";
        // line 23
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "footage"), "html", null, true);
        echo "<br>
Откуда узнали? - ";
        // line 24
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "hear"), "html", null, true);
        echo "<br>
Дополнительная информация - ";
        // line 25
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_result_, "mpre"), "html", null, true);
        echo "<br>

";
        // line 27
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($_result_, "history"));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 28
            echo "  ";
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "name"), "html", null, true);
            echo " - ";
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            if ((twig_length_filter($this->env, $this->getAttribute($_row_, "date")) > 0)) {
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($_row_, "date"), "d.m.Y H:i"), "html", null, true);
            } else {
                echo "Не менялся статус";
            }
            echo "<br>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "card/view.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 28,  113 => 27,  107 => 25,  102 => 24,  97 => 23,  92 => 22,  87 => 21,  82 => 20,  77 => 19,  72 => 18,  67 => 17,  61 => 16,  54 => 13,  50 => 11,  47 => 10,  40 => 7,  36 => 5,  33 => 4,  30 => 3,  25 => 2,);
    }
}
