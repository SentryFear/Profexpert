<?php

/* request/main.html */
class __TwigTemplate_edc1f2b03a0039d4d1978544dfd70be3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("_main.html");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "_main.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Заявки";
    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        // line 6
        echo "  <style>
    .sort .btn {
      font-size: 11px;
      font-family: \"Open sans\", Helvetica, Arial;
      color: #313d4c;
      font-weight: 700;
      padding: 5px 10px;
      line-height: 14px;
      background: #fefefe;
      background: -moz-linear-gradient(top, #fefefe 0%, #f7f7f7 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fefefe), color-stop(100%,#f7f7f7));
      background: -webkit-linear-gradient(top, #fefefe 0%,#f7f7f7 100%);
      background: -o-linear-gradient(top, #fefefe 0%,#f7f7f7 100%);
      background: -ms-linear-gradient(top, #fefefe 0%,#f7f7f7 100%);
      background: linear-gradient(to bottom, #fefefe 0%,#f7f7f7 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefefe', endColorstr='#f7f7f7',GradientType=0 );
      border: 1px solid #d0dde9;
      transition: color .1s linear;
      -moz-transition: color .1s linear;
      -webkit-transition: color .1s linear;
      -o-transition: color .1s linear;
    }
    .sort a:hover {
      color: #a8b5c7;
    }
    .sort a:active, .btn-group a.active {
      -webkit-box-shadow:0 1px 0 rgba(0,0,0,0.2) inset;
      -moz-box-shadow:0 1px 0 rgba(0,0,0,0.2) inset;
      box-shadow:0 1px 0 rgba(0,0,0,0.2) inset;
      color: #a8b5c7;
    }
    .sort .btn:hover, .sort .btn:focus, .sort .btn:active, .sort .btn.active, .sort .btn.disabled, .sort .btn[disabled] {
      background: #fefefe;
      background: -moz-linear-gradient(top, #fefefe 0%, #f7f7f7 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fefefe), color-stop(100%,#f7f7f7));
      background: -webkit-linear-gradient(top, #fefefe 0%,#f7f7f7 100%);
      background: -o-linear-gradient(top, #fefefe 0%,#f7f7f7 100%);
      background: -ms-linear-gradient(top, #fefefe 0%,#f7f7f7 100%);
      background: linear-gradient(to bottom, #fefefe 0%,#f7f7f7 100%);
    }
  </style>
  
  <div class=\"table-wrapper products-table section\">
    <div class=\"row-fluid filter-block\">
\t<div class=\"pull-left\">
\t  <div class=\"btn-group pull-right sort\">
\t\t";
        // line 52
        if (isset($context["sort"])) { $_sort_ = $context["sort"]; } else { $_sort_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_sort_);
        foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
            // line 53
            echo "\t\t  <a href=\"/request/?sort=";
            if (isset($context["i"])) { $_i_ = $context["i"]; } else { $_i_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_i_, "uri"), "html", null, true);
            echo "\" class=\"btn btn-small ";
            if (isset($context["i"])) { $_i_ = $context["i"]; } else { $_i_ = null; }
            if (($this->getAttribute($_i_, "active") == 1)) {
                echo "active";
            }
            echo "\">";
            if (isset($context["i"])) { $_i_ = $context["i"]; } else { $_i_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_i_, "name"), "html", null, true);
            echo "</a>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 55
        echo "            </div>
\t</div>
        <div class=\"pull-right\">
            <input type=\"text\" class=\"search\">
\t    <a href=\"#aNewReq\" data-target=\"#aNewReq\" data-toggle=\"modal\" class=\"btn-flat success new-product\"><i class=\"icon-plus\"></i> <span>Добавить</span></a>
        </div>
    </div>

    <div class=\"row-fluid\">
      <!-- Table -->
\t";
        // line 65
        if (isset($context["result"])) { $_result_ = $context["result"]; } else { $_result_ = null; }
        echo $_result_;
        echo "
      <!-- EndTable -->
      
      <!-- Help for users -->
\t<div class=\"alert alert-info\">
\t  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t  <b>Подсказка</b><br>
\t  &nbsp;&nbsp;&nbsp;&nbsp;* Чтобы загрузить или просмотреть документы нажмите на цифру в столбце <b>ДОКУМЕНТЫ</b>.<br>
\t  &nbsp;&nbsp;&nbsp;&nbsp;* Чтобы добавить информацию или изменить нажмите кнопку <b>Изменить</b>.<br>
\t  &nbsp;&nbsp;&nbsp;&nbsp;* Чтобы распечатать нажмите кнопку <b>Печать</b>.<br>
\t  <b>Cтатусы КП</b><br>
\t  &nbsp;&nbsp;&nbsp;&nbsp;* <b>Ожидание документов</b> - Ожидание получения документов от заказчика<br>
          &nbsp;&nbsp;&nbsp;&nbsp;* <b>Расчет данных</b> - Документы отправлены в отдел проектирования, производится расчёт<br>
          &nbsp;&nbsp;&nbsp;&nbsp;* <b>Согласование сроков</b><br>
          &nbsp;&nbsp;&nbsp;&nbsp;* <b>Оформление предложения</b><br>
          &nbsp;&nbsp;&nbsp;&nbsp;* <b>Согласование стоимости</b><br>
          &nbsp;&nbsp;&nbsp;&nbsp;* <b>Готово к отправке</b><br>
          &nbsp;&nbsp;&nbsp;&nbsp;* <b>Отправлено</b><br>
          &nbsp;&nbsp;&nbsp;&nbsp;* <b>Отказ</b>
\t</div>
      <!-- End Help -->
    </div>
  </div>

  <!-- Modal Upload -->
    ";
        // line 90
        $this->env->loadTemplate("request/upload.html")->display($context);
        // line 91
        echo "  <!-- EndModal Upload -->
  
  <!-- Modal Add -->
    ";
        // line 95
        echo "    ";
        if (isset($context["add"])) { $_add_ = $context["add"]; } else { $_add_ = null; }
        echo $_add_;
        echo "
  <!-- EndModal Add -->
";
    }

    public function getTemplateName()
    {
        return "request/main.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  157 => 95,  152 => 91,  150 => 90,  121 => 65,  109 => 55,  91 => 53,  86 => 52,  38 => 6,  35 => 5,  29 => 3,);
    }
}
