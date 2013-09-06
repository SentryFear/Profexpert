<?php

/* request/add.html */
class __TwigTemplate_8d68e6748b86321a1f84eb54fd3f2ed3 extends Twig_Template
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
        echo "  <div id=\"add\" class=\"modal hide fade\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-header\">
      <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button>
      <h3 id=\"myModalLabel\">Добавить заявку</h3>
    </div>
    <form class=\"form-horizontal\" method=\"POST\" enctype=\"multipart/form-data\" autocomplete=\"off\">
      <div class=\"modal-body\">
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"fname\">ФИО</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"fname\" name=\"fname\" placeholder=\"Фамилия Имя Отчество\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"phone\">Телефон</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"phone\" name=\"phone\" placeholder=\"Номер телефона\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"address\">Адрес</label>
\t  <div class=\"controls\">
\t    <select name=\"region\">
\t\t";
        // line 24
        if (isset($context["region"])) { $_region_ = $context["region"]; } else { $_region_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_region_);
        foreach ($context['_seq'] as $context["key"] => $context["row"]) {
            // line 25
            echo "\t\t  <option value=\"";
            if (isset($context["key"])) { $_key_ = $context["key"]; } else { $_key_ = null; }
            echo twig_escape_filter($this->env, $_key_, "html", null, true);
            echo "\">";
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            echo twig_escape_filter($this->env, $_row_, "html", null, true);
            echo "</option>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "\t    </select>
\t    <input type=\"text\" id=\"address\" name=\"address\" placeholder=\"Адрес\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"ptype\">Тип помещения</label>
\t  <div class=\"controls\">
\t    <select name=\"ptype\" id=\"ptype\">
\t\t  <option value=\"Жилое\">Жилое</option>
\t\t  <option value=\"Коммерческое\">Коммерческое</option>
\t    </select>
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"rtype\">Тип работ</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"rtype\" name=\"rtype\" placeholder=\"Тип работ\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"footage\">Метраж</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"footage\" name=\"footage\" placeholder=\"Метраж\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"hear\">Откуда узнали?</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"hear\" name=\"hear\" placeholder=\"Откуда узнали?\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"more\">Дополнительная информация</label>
\t  <div class=\"controls\">
\t    <textarea placeholder=\"Дополнительная информация\" name=\"more\" id=\"more\"></textarea>
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"Email\">Email</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"Email\" name=\"Email\" placeholder=\"Email адрес\">
\t  </div>
\t</div>
\t<div class=\"control-group\">
\t  <label class=\"control-label\" for=\"history\">История</label>
\t  <div class=\"controls\">
\t    <input type=\"text\" id=\"history\" name=\"history\" placeholder=\"История\">
\t  </div>
\t</div>
      </div>
      <div class=\"modal-footer\">
\t<div class=\"btn-group\">
\t  <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Закрыть</button>
\t  <input type=\"submit\" class=\"btn btn-primary\" name=\"add\" value=\"Добавить\" />
\t</div>
      </div>
    </form>
  </div>";
    }

    public function getTemplateName()
    {
        return "request/add.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 27,  49 => 25,  44 => 24,  19 => 1,  57 => 13,  55 => 12,  50 => 9,  48 => 8,  41 => 5,  38 => 4,  35 => 3,  29 => 2,);
    }
}
