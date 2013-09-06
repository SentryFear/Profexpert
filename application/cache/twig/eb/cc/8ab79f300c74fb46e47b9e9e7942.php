<?php

/* _main.html */
class __TwigTemplate_ebcc8ab79f300c74fb46e47b9e9e7942 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
            'js' => array($this, 'block_js'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    ";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 54
        echo "  </head>
  <body>
    ";
        // line 94
        echo "    <!-- navbar -->
    <div class=\"navbar navbar-inverse\">
        <div class=\"navbar-inner\">
            <button type=\"button\" class=\"btn btn-navbar visible-phone\" id=\"menu-toggler\">
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
                <span class=\"icon-bar\"></span>
            </button>
            
            <a class=\"brand\" href=\"/\">ПРОФЭКСПЕРТ</a>

            <ul class=\"nav pull-right\">                
                <li class=\"hidden-phone\">
                    <input class=\"search\" type=\"text\" />
                </li>
                <li class=\"notification-dropdown hidden-phone\">
                    <a href=\"#\" class=\"trigger\">
                        <i class=\"icon-warning-sign\"></i>
                        <span class=\"count\">8</span>
                    </a>
                    <div class=\"pop-dialog\">
                        <div class=\"pointer right\">
                            <div class=\"arrow\"></div>
                            <div class=\"arrow_border\"></div>
                        </div>
                        <div class=\"body\">
                            <a href=\"#\" class=\"close-icon\"><i class=\"icon-remove-sign\"></i></a>
                            <div class=\"notifications\">
                                <h3>You have 6 new notifications</h3>
                                <a href=\"#\" class=\"item\">
                                    <i class=\"icon-signin\"></i> New user registration
                                    <span class=\"time\"><i class=\"icon-time\"></i> 13 min.</span>
                                </a>
                                <a href=\"#\" class=\"item\">
                                    <i class=\"icon-signin\"></i> New user registration
                                    <span class=\"time\"><i class=\"icon-time\"></i> 18 min.</span>
                                </a>
                                <a href=\"#\" class=\"item\">
                                    <i class=\"icon-envelope-alt\"></i> New message from Alejandra
                                    <span class=\"time\"><i class=\"icon-time\"></i> 28 min.</span>
                                </a>
                                <a href=\"#\" class=\"item\">
                                    <i class=\"icon-signin\"></i> New user registration
                                    <span class=\"time\"><i class=\"icon-time\"></i> 49 min.</span>
                                </a>
                                <a href=\"#\" class=\"item\">
                                    <i class=\"icon-download-alt\"></i> New order placed
                                    <span class=\"time\"><i class=\"icon-time\"></i> 1 day.</span>
                                </a>
                                <div class=\"footer\">
                                    <a href=\"#\" class=\"logout\">View all notifications</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class=\"notification-dropdown hidden-phone\">
                    <a href=\"#\" class=\"trigger\">
                        <i class=\"icon-envelope-alt\"></i>
                    </a>
                    <div class=\"pop-dialog\">
                        <div class=\"pointer right\">
                            <div class=\"arrow\"></div>
                            <div class=\"arrow_border\"></div>
                        </div>
                        <div class=\"body\">
                            <a href=\"#\" class=\"close-icon\"><i class=\"icon-remove-sign\"></i></a>
                            <div class=\"messages\">
                                <a href=\"#\" class=\"item\">
                                    
                                    <div class=\"name\">Alejandra Galván</div>
                                    <div class=\"msg\">
                                        There are many variations of available, but the majority have suffered alterations.
                                    </div>
                                    <span class=\"time\"><i class=\"icon-time\"></i> 13 min.</span>
                                </a>
                                <a href=\"#\" class=\"item\">
                                    
                                    <div class=\"name\">Alejandra Galván</div>
                                    <div class=\"msg\">
                                        There are many variations of available, have suffered alterations.
                                    </div>
                                    <span class=\"time\"><i class=\"icon-time\"></i> 26 min.</span>
                                </a>
                                <a href=\"#\" class=\"item last\">
                                   
                                    <div class=\"name\">Alejandra Galván</div>
                                    <div class=\"msg\">
                                        There are many variations of available, but the majority have suffered alterations.
                                    </div>
                                    <span class=\"time\"><i class=\"icon-time\"></i> 48 min.</span>
                                </a>
                                <div class=\"footer\">
                                    <a href=\"#\" class=\"logout\">View all messages</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class=\"dropdown\">
                    <a href=\"#\" class=\"dropdown-toggle hidden-phone\" data-toggle=\"dropdown\">
                        ";
        // line 195
        if (isset($context["user"])) { $_user_ = $context["user"]; } else { $_user_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_user_, "username"), "html", null, true);
        echo "
                        <b class=\"caret\"></b>
                    </a>
                    <ul class=\"dropdown-menu\">
                        <li><a href=\"personal-info.html\">Personal info</a></li>
                        <li><a href=\"#\">Account settings</a></li>
                        <li><a href=\"#\">Billing</a></li>
                        <li><a href=\"#\">Export your data</a></li>
                        <li><a href=\"#\">Send feedback</a></li>
                    </ul>
                </li>
                <li class=\"settings hidden-phone\">
                    <a href=\"#add\" data-target=\"#add\" data-toggle=\"modal\">
                        <i class=\"icon-cog\"></i>
                    </a>
                </li>
                <li class=\"settings hidden-phone\">
                    <a href=\"/auth/logout\" role=\"button\">
                        <i class=\"icon-share-alt\"></i>
                    </a>
                </li>
            </ul>            
        </div>
    </div>
    <!-- end navbar -->
        <!-- sidebar -->
    <div id=\"sidebar-nav\">
        <ul id=\"dashboard-menu\">
\t      <li ";
        // line 223
        if (isset($context["segments"])) { $_segments_ = $context["segments"]; } else { $_segments_ = null; }
        if ((twig_length_filter($this->env, $this->getAttribute($_segments_, 1)) == 0)) {
            echo "class=\"active\"";
        }
        echo "><a href=\"/\">";
        if (isset($context["segments"])) { $_segments_ = $context["segments"]; } else { $_segments_ = null; }
        if ((twig_length_filter($this->env, $this->getAttribute($_segments_, 1)) == 0)) {
            echo "<div class=\"pointer\"><div class=\"arrow\"></div><div class=\"arrow_border\"></div></div>";
        }
        echo "<i class=\"icon-home\"></i><span>Главная</span></a></li>
\t      ";
        // line 224
        if (isset($context["menu"])) { $_menu_ = $context["menu"]; } else { $_menu_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_menu_);
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 225
            echo "\t\t";
            if (isset($context["access"])) { $_access_ = $context["access"]; } else { $_access_ = null; }
            if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
            if ((($_access_ == "admin") || twig_in_filter($this->getAttribute($_row_, "cpu"), $_access_))) {
                // line 226
                echo "\t\t  <li ";
                if (isset($context["segments"])) { $_segments_ = $context["segments"]; } else { $_segments_ = null; }
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                if (((twig_length_filter($this->env, $this->getAttribute($_segments_, 2)) == 0) && (trim($this->getAttribute($_segments_, 1), "/") == trim($this->getAttribute($_row_, "cpu"), "/")))) {
                    echo "class=\"active\"";
                }
                echo ">
\t\t    ";
                // line 227
                if (isset($context["segments"])) { $_segments_ = $context["segments"]; } else { $_segments_ = null; }
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                if (((twig_length_filter($this->env, $this->getAttribute($_segments_, 2)) == 0) && (trim($this->getAttribute($_segments_, 1), "/") == trim($this->getAttribute($_row_, "cpu"), "/")))) {
                    echo "<div class=\"pointer\"><div class=\"arrow\"></div><div class=\"arrow_border\"></div></div>";
                }
                // line 228
                echo "\t\t    <a href=\"";
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_row_, "cpu"), "html", null, true);
                echo "\" ";
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_row_, "self"), "html", null, true);
                echo ">";
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                echo $this->getAttribute($_row_, "icon");
                echo " <span>";
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                echo twig_escape_filter($this->env, $this->getAttribute($_row_, "name"), "html", null, true);
                echo "</span></a>
\t\t  </li>
\t\t  ";
                // line 230
                if (isset($context["segments"])) { $_segments_ = $context["segments"]; } else { $_segments_ = null; }
                if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                if ((trim($this->getAttribute($_segments_, 1), "/") == trim($this->getAttribute($_row_, "cpu"), "/"))) {
                    // line 231
                    echo "\t\t    ";
                    if (isset($context["row"])) { $_row_ = $context["row"]; } else { $_row_ = null; }
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($_row_, "menu"));
                    foreach ($context['_seq'] as $context["_key"] => $context["row1"]) {
                        // line 232
                        echo "\t\t      <li ";
                        if (isset($context["segments"])) { $_segments_ = $context["segments"]; } else { $_segments_ = null; }
                        if (isset($context["row1"])) { $_row1_ = $context["row1"]; } else { $_row1_ = null; }
                        if ((((trim($this->getAttribute($_segments_, 1), "/") . "/") . trim($this->getAttribute($_segments_, 2), "/")) == trim($this->getAttribute($_row1_, "cpu"), "/"))) {
                            echo "class=\"active\"";
                        }
                        echo ">
\t\t\t";
                        // line 233
                        if (isset($context["segments"])) { $_segments_ = $context["segments"]; } else { $_segments_ = null; }
                        if (isset($context["row1"])) { $_row1_ = $context["row1"]; } else { $_row1_ = null; }
                        if ((((trim($this->getAttribute($_segments_, 1), "/") . "/") . trim($this->getAttribute($_segments_, 2), "/")) == trim($this->getAttribute($_row1_, "cpu"), "/"))) {
                            echo "<div class=\"pointer\"><div class=\"arrow\"></div><div class=\"arrow_border\"></div></div>";
                        }
                        // line 234
                        echo "\t\t\t<a href=\"";
                        if (isset($context["row1"])) { $_row1_ = $context["row1"]; } else { $_row1_ = null; }
                        echo twig_escape_filter($this->env, $this->getAttribute($_row1_, "cpu"), "html", null, true);
                        echo "\" ";
                        if (isset($context["row1"])) { $_row1_ = $context["row1"]; } else { $_row1_ = null; }
                        echo twig_escape_filter($this->env, $this->getAttribute($_row1_, "self"), "html", null, true);
                        echo ">";
                        if (isset($context["row1"])) { $_row1_ = $context["row1"]; } else { $_row1_ = null; }
                        echo $this->getAttribute($_row1_, "icon");
                        echo " <span>";
                        if (isset($context["row1"])) { $_row1_ = $context["row1"]; } else { $_row1_ = null; }
                        echo twig_escape_filter($this->env, $this->getAttribute($_row1_, "name"), "html", null, true);
                        echo "</span></a>
\t\t      </li>
\t\t    ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row1'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 237
                    echo "\t\t  ";
                }
                // line 238
                echo "\t\t";
            }
            // line 239
            echo "\t      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 240
        echo "        </ul>
    </div>
    <!-- end sidebar -->
    \t<!-- main container -->
    <div class=\"content\">
        <div class=\"container-fluid\">
            <div id=\"pad-wrapper\">
                ";
        // line 247
        if (isset($context["success"])) { $_success_ = $context["success"]; } else { $_success_ = null; }
        if ((twig_length_filter($this->env, $_success_) > 0)) {
            // line 248
            echo "\t\t  <div class=\"alert alert-success\">
\t\t    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t    <strong>";
            // line 250
            if (isset($context["success"])) { $_success_ = $context["success"]; } else { $_success_ = null; }
            echo $_success_;
            echo "</strong>
\t\t  </div>
\t\t";
        }
        // line 253
        echo "\t\t";
        if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
        if ((twig_length_filter($this->env, $_error_) > 0)) {
            // line 254
            echo "\t\t  <div class=\"alert alert-error\">
\t\t    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
\t\t    <strong>";
            // line 256
            if (isset($context["error"])) { $_error_ = $context["error"]; } else { $_error_ = null; }
            echo $_error_;
            echo "</strong>
\t\t  </div>
\t\t";
        }
        // line 259
        echo "\t\t";
        $this->displayBlock('content', $context, $blocks);
        // line 260
        echo "            </div>
        </div>
    </div>
    <!-- end main container -->
    
    ";
        // line 272
        echo "    
    ";
        // line 273
        $this->displayBlock('js', $context, $blocks);
        // line 293
        echo "  </body>
</html>
";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "      <meta charset=\"utf-8\">
      <title>";
        // line 6
        $this->displayBlock('title', $context, $blocks);
        echo " - ПРОФЭКСПЕРТ</title>
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
      <meta name=\"description\" content=\"\">
      <meta name=\"author\" content=\"\">
  
      ";
        // line 21
        echo "          <!-- bootstrap -->
    <link href=\"/themes/wrap/css/bootstrap/bootstrap.css\" rel=\"stylesheet\" />
    <link href=\"/themes/wrap/css/bootstrap/bootstrap-responsive.css\" rel=\"stylesheet\" />
    <link href=\"/themes/wrap/css/bootstrap/bootstrap-overrides.css\" type=\"text/css\" rel=\"stylesheet\" />
    
    <link href=\"/themes/wrap/js/jquery.formstyler.css\" rel=\"stylesheet\" />

    <!-- libraries -->
    <link href=\"/themes/wrap/css/lib/jquery-ui-1.10.2.custom.css\" rel=\"stylesheet\" type=\"text/css\" />
    <link href=\"/themes/wrap/css/lib/font-awesome.css\" type=\"text/css\" rel=\"stylesheet\" />
    
    <!-- this page specific styles -->
    <link rel=\"stylesheet\" href=\"/themes/wrap/css/compiled/tables.css\" type=\"text/css\" media=\"screen\" />
    <link rel=\"stylesheet\" href=\"/themes/wrap/css/custom.css\" type=\"text/css\" media=\"screen\" />
    
    <!-- global styles -->
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/wrap/css/layout.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/wrap/css/elements.css\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/themes/wrap/css/icons.css\">

    <!-- this page specific styles -->
    <link rel=\"stylesheet\" href=\"/themes/wrap/css/compiled/index.css\" type=\"text/css\" media=\"screen\" />    

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- lato font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
      <script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>
    <![endif]-->
    ";
    }

    // line 6
    public function block_title($context, array $blocks = array())
    {
    }

    // line 259
    public function block_content($context, array $blocks = array())
    {
    }

    // line 273
    public function block_js($context, array $blocks = array())
    {
        // line 274
        echo "    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    ";
        // line 280
        echo "    \t<!-- scripts -->
    <script src=\"http://code.jquery.com/jquery-latest.js\"></script>
    <script src=\"/themes/wrap/js/bootstrap.min.js\"></script>
    <script src=\"/themes/wrap/js/jquery-ui-1.10.2.custom.min.js\"></script>
    <!-- knob -->
    <script src=\"/themes/wrap/js/jquery.knob.js\"></script>
    <!-- flot charts -->
    <script src=\"/themes/wrap/js/jquery.flot.js\"></script>
    <script src=\"/themes/wrap/js/jquery.flot.stack.js\"></script>
    <script src=\"/themes/wrap/js/jquery.flot.resize.js\"></script>
    <script src=\"/themes/wrap/js/theme.js\"></script>
    <script src=\"/themes/wrap/js/jquery.formstyler.min.js\"></script>
    ";
    }

    public function getTemplateName()
    {
        return "_main.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  406 => 280,  401 => 274,  398 => 273,  393 => 259,  388 => 6,  352 => 21,  344 => 6,  341 => 5,  338 => 4,  332 => 293,  330 => 273,  327 => 272,  320 => 260,  317 => 259,  310 => 256,  306 => 254,  302 => 253,  295 => 250,  291 => 248,  288 => 247,  279 => 240,  273 => 239,  270 => 238,  267 => 237,  247 => 234,  241 => 233,  232 => 232,  226 => 231,  222 => 230,  206 => 228,  200 => 227,  191 => 226,  186 => 225,  181 => 224,  169 => 223,  137 => 195,  34 => 94,  30 => 54,  28 => 4,  23 => 1,);
    }
}
