<?php

/* card/main.html */
class __TwigTemplate_578d0af961761b3daba51fe44d97e82c extends Twig_Template
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
        echo "<table class=\"table table-hover table-bordered\">
  <thead>
    <tr>
      <th>#</th>
      <th>ФИО</th>
      <th>Телефон</th>
      <th>Почта</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
\t";
        // line 27
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_result_);
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
            // line 28
            echo "\t\t<tr>
\t\t\t<td>";
            // line 29
            if (isset($context["loop"])) { $_loop_ = $context["loop"]; } else { $_loop_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_loop_, "index"), "html", null, true);
            echo " </td>
\t\t\t<td>";
            // line 30
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "fname"), "html", null, true);
            echo " </td>
\t\t\t<td>";
            // line 31
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "phone"), "html", null, true);
            echo " </td>
\t\t\t<td>";
            // line 32
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "email"), "html", null, true);
            echo " </td>
\t\t\t<td><div class=\"btn-group\"><a href=\"/card/view/";
            // line 33
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "/\" class=\"btn btn-mini\">Подробнее</a><a href=\"/card/edit/";
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "/\" class=\"btn btn-mini\">Изменить</a><a href=\"/card/delete/";
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_row_, "id"), "html", null, true);
            echo "/\" class=\"btn btn-mini btn-danger\">Удалить</a></div></td>
\t\t</tr>
\t";
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
        // line 36
        echo "  </tbody>
</table>
<!-- Modal -->
<div id=\"upload\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-header\">
    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
    <h3 id=\"myModalLabel\">Загрузить документы</h3>
  </div>
  <div class=\"modal-body\">
    <blockquote>
      <p>Права на собственность <input type=\"file\" /></p>
      <small>Загрузил <b>Admin</b> 22.07.2013 в 15:24 </small>
    </blockquote>
    <blockquote>
      <p>Технический паспорт <input type=\"file\" /></p>
      <small>Загрузил <b>Admin</b> 22.07.2013 в 15:24 </small>
    </blockquote>
    <blockquote>
      <p>Эскиз перепланировки <input type=\"file\" /></p>
      <small>Загрузил <b>Admin</b> 22.07.2013 в 15:24 </small>
    </blockquote>
  </div>
  <div class=\"modal-footer\">
    <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Закрыть</button>
    <button class=\"btn btn-primary\">Загрузить</button>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "card/main.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  139 => 36,  115 => 33,  110 => 32,  105 => 31,  100 => 30,  95 => 29,  92 => 28,  74 => 27,  61 => 16,  54 => 13,  50 => 11,  47 => 10,  40 => 7,  36 => 5,  33 => 4,  30 => 3,  25 => 2,);
    }
}
