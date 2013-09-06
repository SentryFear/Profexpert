<?php

/* users/main.html */
class __TwigTemplate_60fd3af239fc8cf92c88faff21e9d26b extends Twig_Template
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
        $context["active"] = "usr";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "  <div class=\"table-wrapper products-table section\">

    <div class=\"row-fluid\">
      <!-- Table -->
      <form method=\"POST\">
\t<table class=\"table table-hover\">
\t  <thead>
\t     <tr>
\t      <th width=\"2%\"><input type=\"checkbox\" name=\"chec\"></th>
\t      <th width=\"2%\"><span class=\"line\"></span>#</th>
\t      <th><span class=\"line\"></span>Логин</th>
\t      <th><span class=\"line\"></span>ФИО</th>
\t      <th><span class=\"line\"></span>Email</th>
\t      <th><span class=\"line\"></span>Отдел</th>
\t      <th><span class=\"line\"></span>IP адрес</th>
\t      <th><span class=\"line\"></span>Последняя авторизация</th>
\t      <th><span class=\"line\"></span>Создан</th>
\t    </tr>
\t  </thead>
\t  <tbody>
\t    ";
        // line 24
        if (isset($context["users"])) { $_users_ = $context["users"]; } else { $_users_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_users_);
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 25
            echo "\t      <tr>
\t\t<td><input type=\"checkbox\" name=\"checkbox_";
            // line 26
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "\" value=\"";
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "\"></td>
\t\t<td>";
            // line 27
            if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index"), "html", null, true);
            echo "</td>
\t\t<td>";
            // line 28
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "username"), "html", null, true);
            echo "</td>
\t\t<td>";
            // line 29
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "name"), "html", null, true);
            echo "</td>
\t\t<td>";
            // line 30
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "email"), "html", null, true);
            echo "</td>
\t\t<td>";
            // line 31
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "role_name"), "html", null, true);
            echo "</td>
\t\t<td>";
            // line 32
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "last_ip"), "html", null, true);
            echo "</td>
\t\t<td>";
            // line 33
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "last_login"), "html", null, true);
            echo "</td>
\t\t<td>";
            // line 34
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "created"), "html", null, true);
            echo "</td>
\t\t";
            // line 36
            echo "\t      </tr>
\t    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 38
        echo "\t  </tbody>
\t</table>
\t<div class=\"form-actions\">
\t  <input type=\"submit\" name=\"delete\" class=\"btn btn-danger\" value=\"Удалить выделенне\"/>
\t</div>
\t</form>
      <!-- EndTable -->
    </div>
  </div>
<div id=\"add\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-header\">
    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
    <h3 id=\"myModalLabel\">Добавить пользователя</h3>
  </div>
  <form class=\"form-horizontal\" method=\"POST\" enctype=\"multipart/form-data\" autocomplete=\"off\">
    <div class=\"modal-body\">
        <div class=\"control-group\">
\t  <label class=\"control-label\" for=\"user\">Логин</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"user\" name=\"user\" placeholder=\"Логин для входа в панель\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"pass\">Пароль</label>
\t  <div class=\"controls\">
\t    <input type=\"password\" id=\"pass\" name=\"pass\" placeholder=\"Пароль для входа в панель\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"name\">ФИО</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"name\" name=\"name\" placeholder=\"Фамилия Имя Отчество\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"email\">Email</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"email\" name=\"email\" placeholder=\"Электронный адрес\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"role\">Отдел</label>
\t  <div class=\"controls\">
\t    <select id=\"role\" name=\"role\">
\t\t";
        // line 82
        if (isset($context["roles"])) { $_roles_ = $context["roles"]; } else { $_roles_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_roles_);
        foreach ($context['_seq'] as $context["_key"] => $context["role"]) {
            // line 83
            echo "\t\t  <option value=\"";
            if (isset($context["role"])) { $_role_ = $context["role"]; } else { $_role_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_role_, "id"), "html", null, true);
            echo "\">";
            if (isset($context["role"])) { $_role_ = $context["role"]; } else { $_role_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_role_, "name"), "html", null, true);
            echo "</option>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['role'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 85
        echo "\t    </select>
\t  </div>
\t</div>
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
        return "users/main.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  203 => 85,  190 => 83,  185 => 82,  139 => 38,  124 => 36,  119 => 34,  114 => 33,  109 => 32,  104 => 31,  99 => 30,  94 => 29,  89 => 28,  84 => 27,  76 => 26,  73 => 25,  55 => 24,  33 => 4,  30 => 3,  25 => 2,);
    }
}
