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

/* themes/contrib/zuvi/templates/layout/page.html.twig */
class __TwigTemplate_f72053a59520235191954e03328c4dcb extends Template
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
        // line 52
        yield from $this->loadTemplate("@zuvi/template-parts/header.html.twig", "themes/contrib/zuvi/templates/layout/page.html.twig", 52)->unwrap()->yield($context);
        // line 53
        yield from $this->loadTemplate("@zuvi/template-parts/highlighted.html.twig", "themes/contrib/zuvi/templates/layout/page.html.twig", 53)->unwrap()->yield($context);
        // line 54
        yield "<div id=\"main-wrapper\" class=\"main-wrapper\">
  <div class=\"container\">
  <div class=\"main-container\">
    <main id=\"main\" class=\"full-width page-content\">
      <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 59
        yield "      ";
        yield from $this->loadTemplate("@zuvi/template-parts/content_top.html.twig", "themes/contrib/zuvi/templates/layout/page.html.twig", 59)->unwrap()->yield($context);
        // line 60
        yield "      ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 60), "html", null, true);
        yield "
      ";
        // line 61
        yield from $this->loadTemplate("@zuvi/template-parts/content_bottom.html.twig", "themes/contrib/zuvi/templates/layout/page.html.twig", 61)->unwrap()->yield($context);
        // line 62
        yield "    </main>
    ";
        // line 63
        yield from $this->loadTemplate("@zuvi/template-parts/sidebar_left.html.twig", "themes/contrib/zuvi/templates/layout/page.html.twig", 63)->unwrap()->yield($context);
        // line 64
        yield "    ";
        yield from $this->loadTemplate("@zuvi/template-parts/sidebar_right.html.twig", "themes/contrib/zuvi/templates/layout/page.html.twig", 64)->unwrap()->yield($context);
        // line 65
        yield "  </div>";
        // line 66
        yield "  </div>";
        // line 67
        yield "</div>";
        // line 68
        yield from $this->loadTemplate("@zuvi/template-parts/footer.html.twig", "themes/contrib/zuvi/templates/layout/page.html.twig", 68)->unwrap()->yield($context);
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/contrib/zuvi/templates/layout/page.html.twig";
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
        return array (  78 => 68,  76 => 67,  74 => 66,  72 => 65,  69 => 64,  67 => 63,  64 => 62,  62 => 61,  57 => 60,  54 => 59,  48 => 54,  46 => 53,  44 => 52,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/contrib/zuvi/templates/layout/page.html.twig", "/var/www/html/web/themes/contrib/zuvi/templates/layout/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 52];
        static $filters = ["escape" => 60];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['include'],
                ['escape'],
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
