<?php

/* users/uri_permissions.html */
class __TwigTemplate_296cebc0cfb09e22c4300bff479e251b extends Twig_Template
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
        $context["active"] = "urp";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "<form method=\"POST\" class=\"form-horizontal\">
    <div class=\"control-group\">
        <label class=\"control-label\" for=\"allowed_uris\">Выберите отдел</label>
        <div class=\"controls\">
            <div class=\"input-append\">";
        // line 8
        if (isset($context["request"])) { $_request_ = $context["request"]; } else { $_request_ = null; }
        echo twig_escape_filter($this->env, $this->getAttribute($_request_, "post", array(0 => "role"), "method"), "html", null, true);
        echo "
                <select name=\"role\">
                    ";
        // line 10
        if (isset($context["roles"])) { $_roles_ = $context["roles"]; } else { $_roles_ = null; }
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($_roles_);
        foreach ($context['_seq'] as $context["_key"] => $context["role"]) {
            // line 11
            echo "                        <option value=\"";
            if (isset($context["role"])) { $_role_ = $context["role"]; } else { $_role_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_role_, "id"), "html", null, true);
            echo "\" ";
            if (isset($context["trole"])) { $_trole_ = $context["trole"]; } else { $_trole_ = null; }
            if (isset($context["role"])) { $_role_ = $context["role"]; } else { $_role_ = null; }
            if (($_trole_ == $this->getAttribute($_role_, "id"))) {
                echo "selected";
            }
            echo ">";
            if (isset($context["role"])) { $_role_ = $context["role"]; } else { $_role_ = null; }
            echo twig_escape_filter($this->env, $this->getAttribute($_role_, "name"), "html", null, true);
            echo "</option>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['role'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "                </select>
                <input type=\"submit\" name=\"show\" class=\"btn\" value=\"Показать разрешения отдела\">
            </div>
        </div>
    </div>
    <div class=\"control-group\">
        <label class=\"control-label\" for=\"allowed_uris\">Разрешеня</label>
        <div class=\"controls\">
            <textarea cols=\"40\" rows=\"10\" name=\"allowed_uris\" id=\"allowed_uris\">";
        // line 21
        if (isset($context["allowed_uris"])) { $_allowed_uris_ = $context["allowed_uris"]; } else { $_allowed_uris_ = null; }
        echo twig_escape_filter($this->env, twig_join_filter($_allowed_uris_, "
"), "html", null, true);
        echo "</textarea>
        </div>
    </div>
    <div class=\"form-actions\">
        <input type=\"submit\" name=\"save\" value=\"Сохранить\" class=\"btn btn-primary\" />
    </div>
</form>
";
    }

    public function getTemplateName()
    {
        return "users/uri_permissions.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  79 => 21,  69 => 13,  50 => 11,  45 => 10,  39 => 8,  33 => 4,  30 => 3,  25 => 2,);
    }
}
