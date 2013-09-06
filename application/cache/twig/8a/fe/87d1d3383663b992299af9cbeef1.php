<?php

/* auth/login_form.html */
class __TwigTemplate_8afe87d1d3383663b992299af9cbeef1 extends Twig_Template
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
        echo "<!DOCTYPE html>
<html class=\"login-bg\">
<head>
    <title>Profexpert</title>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    
    <!-- bootstrap -->
    <link href=\"/themes/wrap/css/bootstrap/bootstrap.css\" rel=\"stylesheet\">
    <link href=\"/themes/wrap/css/bootstrap/bootstrap-responsive.css\" rel=\"stylesheet\">
    <link href=\"/themes/wrap/css/bootstrap/bootstrap-overrides.css\" type=\"text/css\" rel=\"stylesheet\">

    <!-- global styles -->
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/wrap/css/layout.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/wrap/css/elements.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/wrap/css/icons.css\">

    <!-- libraries -->
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/wrap/css/lib/font-awesome.css\">
    
    <!-- this page specific styles -->
    <link rel=\"stylesheet\" href=\"/themes/wrap/css/compiled/signin.css\" type=\"text/css\" media=\"screen\" />

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
      <script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>
    <![endif]-->
</head>
<body>
    <div class=\"row-fluid login-wrapper\">
        <a href=\"/\">
            <img class=\"logo\" ";
        // line 34
        echo ">
        </a>
\t  <div class=\"span4 box\">
\t    <form class=\"form-signin\" method=\"post\" action=\"/\">
\t      <div class=\"content-wrap\">
\t\t";
        // line 39
        if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
        if ((twig_length_filter($this->env, $_error_) > 0)) {
            // line 40
            echo "\t\t<div class=\"alert alert-error\">
\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t\t<strong>";
            // line 42
            if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
            echo $_error_;
            echo "</strong>
\t\t</div>
\t\t";
        }
        // line 45
        echo "\t\t  <h6>Панель управления</h6>
\t\t  <input class=\"span12\" name=\"username\" type=\"text\" placeholder=\"Ваш Логин или E-mail адрес\">
\t\t  <input class=\"span12\" name=\"password\" type=\"password\" placeholder=\"Ваш пароль\">
\t\t  ";
        // line 49
        echo "\t\t  <div class=\"remember\">
\t\t      <input id=\"remember-me\" type=\"checkbox\" name=\"remember\" value=\"1\">
\t\t      <label for=\"remember-me\">Запомнить меня</label>
\t\t  </div>
\t\t  <input type=\"submit\" name=\"login\" value=\"Войти\" class=\"btn-glow primary login\">
\t      </div>
\t    </form>
\t  </div>
\t
        ";
        // line 62
        echo "    </div>

\t<!-- scripts -->
    <script src=\"http://code.jquery.com/jquery-latest.js\"></script>
    <script src=\"/themes/wrap/js/bootstrap.min.js\"></script>
    <script src=\"/themes/wrap/js/theme.js\"></script>

    <!-- pre load bg imgs -->
    <script type=\"text/javascript\">
        \$(function () {
            // bg switcher
            var \$btns = \$(\".bg-switch .bg\");
            \$btns.click(function (e) {
                e.preventDefault();
                \$btns.removeClass(\"active\");
                \$(this).addClass(\"active\");
                var bg = \$(this).data(\"img\");

                \$(\"html\").css(\"background-image\", \"url('img/bgs/\" + bg + \"')\");
            });

        });
    </script>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "auth/login_form.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 62,  80 => 49,  75 => 45,  68 => 42,  64 => 40,  61 => 39,  54 => 34,  19 => 1,);
    }
}
