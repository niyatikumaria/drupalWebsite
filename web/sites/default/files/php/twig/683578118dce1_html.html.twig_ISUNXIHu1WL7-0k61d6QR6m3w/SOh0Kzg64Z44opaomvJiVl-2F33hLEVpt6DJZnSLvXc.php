<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* themes/contrib/zuvi/templates/layout/html.html.twig */
class __TwigTemplate_a8995d2d900cae37dd6bdf1b7a6ab0b2 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 26
        yield "
";
        // line 29
        $context["body_classes"] = [((        // line 30
($context["logged_in"] ?? null)) ? ("user-logged-in") : ("user-guest")), (( !        // line 31
($context["root_path"] ?? null)) ? ("homepage") : (("site-page inner-page path-" . \Drupal\Component\Utility\Html::getClass(($context["root_path"] ?? null))))), ((CoreExtension::getAttribute($this->env, $this->source,         // line 32
($context["page"] ?? null), "slider", [], "any", false, false, true, 32)) ? ("page-slider") : ("")), ((        // line 33
($context["node_type"] ?? null)) ? (("page-type-" . \Drupal\Component\Utility\Html::getClass(($context["node_type"] ?? null)))) : ("")), ((( !CoreExtension::getAttribute($this->env, $this->source,         // line 34
($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 34) &&  !CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 34))) ? ("no-sidebar") : ("")), (((CoreExtension::getAttribute($this->env, $this->source,         // line 35
($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 35) &&  !CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 35))) ? ("one-sidebar sidebar-left") : ("")), (((CoreExtension::getAttribute($this->env, $this->source,         // line 36
($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 36) &&  !CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 36))) ? ("one-sidebar sidebar-right") : ("")), (((CoreExtension::getAttribute($this->env, $this->source,         // line 37
($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 37) && CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 37))) ? ("two-sidebar") : (""))];
        // line 40
        yield "<!DOCTYPE html>
<html";
        // line 41
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["html_attributes"] ?? null), "html", null, true);
        yield ">
  <head>
    <head-placeholder token=\"";
        // line 43
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
    <title>";
        // line 44
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, ($context["head_title"] ?? null), " | "));
        yield "</title>
    <link rel=\"preload\" as=\"font\" href=\"";
        // line 45
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/fonts/open-sans.woff2\" type=\"font/woff2\" crossorigin>
    <link rel=\"preload\" as=\"font\" href=\"";
        // line 46
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/fonts/roboto.woff2\" type=\"font/woff2\" crossorigin>
    <link rel=\"preload\" as=\"font\" href=\"";
        // line 47
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/fonts/roboto-bold.woff2\" type=\"font/woff2\" crossorigin>
    <css-placeholder token=\"";
        // line 48
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
    <js-placeholder token=\"";
        // line 49
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
";
        // line 50
        if (($context["styling"] ?? null)) {
            // line 51
            yield "<style>
";
            // line 52
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["styling_code"] ?? null));
            yield "
</style>
";
        }
        // line 55
        yield "  </head>
  <body";
        // line 56
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["body_classes"] ?? null)], "method", false, false, true, 56), "html", null, true);
        yield ">
    ";
        // line 61
        yield "    <a href=\"#main-content\" class=\"visually-hidden focusable\">
      ";
        // line 62
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Skip to main content"));
        yield "
    </a>
    ";
        // line 64
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["page_top"] ?? null), "html", null, true);
        yield "
    ";
        // line 65
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["page"] ?? null), "html", null, true);
        yield "
    ";
        // line 66
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["page_bottom"] ?? null), "html", null, true);
        yield "
    <js-bottom-placeholder token=\"";
        // line 67
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["placeholder_token"] ?? null), "html", null, true);
        yield "\">
  </body>
</html>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["logged_in", "root_path", "page", "node_type", "html_attributes", "placeholder_token", "head_title", "base_path", "directory", "styling", "styling_code", "attributes", "page_top", "page_bottom"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/contrib/zuvi/templates/layout/html.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  131 => 67,  127 => 66,  123 => 65,  119 => 64,  114 => 62,  111 => 61,  107 => 56,  104 => 55,  98 => 52,  95 => 51,  93 => 50,  89 => 49,  85 => 48,  81 => 47,  77 => 46,  73 => 45,  69 => 44,  65 => 43,  60 => 41,  57 => 40,  55 => 37,  54 => 36,  53 => 35,  52 => 34,  51 => 33,  50 => 32,  49 => 31,  48 => 30,  47 => 29,  44 => 26,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/contrib/zuvi/templates/layout/html.html.twig", "/var/www/html/web/themes/contrib/zuvi/templates/layout/html.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 29, "if" => 50];
        static $filters = ["clean_class" => 31, "escape" => 41, "safe_join" => 44, "raw" => 52, "t" => 62];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['clean_class', 'escape', 'safe_join', 'raw', 't'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
