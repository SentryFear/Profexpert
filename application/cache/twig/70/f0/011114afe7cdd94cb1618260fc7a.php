<?php

/* users/roles.html */
class __TwigTemplate_70f0011114afe7cdd94cb1618260fc7a extends Twig_Template
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
        $context["active"] = "rls";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "  <div class=\"table-wrapper products-table section\">
    <div class=\"row-fluid\">
\t<form method=\"POST\">
\t<table class=\"table table-hover\">
\t  <thead>
\t    <tr>
\t      <th width=\"2%\">#</th>
\t      <th width=\"2%\"><span class=\"line\"></span>ID</th>
\t      <th width=\"90%\"><span class=\"line\"></span>Название</th>
\t      <th><span class=\"line\"></span>Родительский ID</th>
\t      <th><span class=\"line\"></span>Действия</th>
\t    </tr>
\t  </thead>
\t  <tbody>
\t\t";
        // line 18
        if (isset($context["roles"])) { $_roles_ = $context["roles"]; } else { $_roles_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_roles_);
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 19
            echo "\t\t  <tr>
\t\t    <td><input type=\"checkbox\" name=\"checkbox_";
            // line 20
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "\" value=\"";
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "\"></td>
\t\t    <td>";
            // line 21
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "</td>
\t\t    <td>";
            // line 22
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "name"), "html", null, true);
            echo "</td>
\t\t    <td>";
            // line 23
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "parent_id"), "html", null, true);
            echo "</td>
\t\t    <td><a href=\"/users/uri_permissions/";
            // line 24
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "/\" class=\"btn btn-mini\">Разрешения</a></td>
\t\t    ";
            // line 26
            echo "\t\t  </tr>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "\t  </tbody>
\t</table>
\t<div class=\"form-actions\">
\t  <input type=\"submit\" name=\"delete\" class=\"btn btn-danger\" value=\"Удалить выделенне\"/>
\t</div>
\t</form>
    </div>
  </div>
<div id=\"add\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-header\">
    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
    <h3 id=\"myModalLabel\">Добавить отдел</h3>
  </div>
  <form method=\"POST\" enctype=\"multipart/form-data\" class=\"form-horizontal\">
    <div class=\"modal-body\">
      <div class=\"control-group\">
\t<label class=\"control-label\" for=\"role_name\">Наименование</label>
\t<div class=\"controls\">
\t  <input type=\"text\" id=\"role_name\" name=\"role_name\" placeholder=\"Наименование отдела\">
\t</div>
      </div>
      <div class=\"control-group\">
\t<label class=\"control-label\" for=\"role_parent\">Родтельский ID</label>
\t<div class=\"controls\">
\t  <select id=\"role_parent\" name=\"role_parent\">
\t    <option value=\"0\">Без родителя</option>
\t    ";
        // line 54
        if (isset($context["roles"])) { $_roles_ = $context["roles"]; } else { $_roles_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_roles_);
        foreach ($context['_seq'] as $context["_key"] => $context["role"]) {
            // line 55
            echo "\t      <option value=\"";
            if (isset($context["role"])) { $_role_ = $context["role"]; } else { $_role_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_role_, "id"), "html", null, true);
            echo "\">";
            if (isset($context["role"])) { $_role_ = $context["role"]; } else { $_role_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_role_, "name"), "html", null, true);
            echo "</option>
\t    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['role'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 57
        echo "\t  </select>
\t</div>
      </div>
    </div>
    <div class=\"modal-footer\">
      <div class=\"btn-group\">
        <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Закрыть</button>
        <input type=\"submit\" class=\"btn btn-primary\" name=\"add\" value=\"Добавить\" />
      </div>
    </div>
  </form>
</div>
";
    }

    public function getTemplateName()
    {
        return "users/roles.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  138 => 57,  125 => 55,  120 => 54,  92 => 28,  85 => 26,  80 => 24,  75 => 23,  70 => 22,  65 => 21,  57 => 20,  54 => 19,  49 => 18,  33 => 4,  30 => 3,  25 => 2,);
    }
}
