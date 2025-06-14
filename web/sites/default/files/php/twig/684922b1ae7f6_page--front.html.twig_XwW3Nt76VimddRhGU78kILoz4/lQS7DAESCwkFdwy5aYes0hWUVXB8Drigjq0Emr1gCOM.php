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

/* themes/contrib/zuvi/templates/layout/page--front.html.twig */
class __TwigTemplate_d05e0e0c2aafcd9f2f092a0d93eb1768 extends Template
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
        // line 11
        yield from $this->loadTemplate("@zuvi/template-parts/header.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 11)->unwrap()->yield($context);
        // line 12
        yield from $this->loadTemplate("@zuvi/template-parts/highlighted.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 12)->unwrap()->yield($context);
        // line 13
        yield "<div id=\"main-wrapper\" class=\"main-wrapper\">
  <div class=\"container\">
    ";
        // line 15
        if (($context["front_sidebar"] ?? null)) {
            // line 16
            yield "      <div class=\"main-container\">
    ";
        }
        // line 18
        yield "    <main id=\"home-main\" class=\"full-width page-content home-content\">
      <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 20
        yield "      ";
        yield from $this->loadTemplate("@zuvi/template-parts/content_top.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 20)->unwrap()->yield($context);
        // line 21
        yield "      ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 21), "html", null, true);
        yield "
      ";
        // line 22
        yield from $this->loadTemplate("@zuvi/template-parts/content_home.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 22)->unwrap()->yield($context);
        // line 23
        yield "      ";
        yield from $this->loadTemplate("@zuvi/template-parts/content_bottom.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 23)->unwrap()->yield($context);
        // line 24
        yield "    </main>
    ";
        // line 25
        if (($context["front_sidebar"] ?? null)) {
            // line 26
            yield "      ";
            yield from $this->loadTemplate("@zuvi/template-parts/sidebar_left.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 26)->unwrap()->yield($context);
            // line 27
            yield "      ";
            yield from $this->loadTemplate("@zuvi/template-parts/sidebar_right.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 27)->unwrap()->yield($context);
            // line 28
            yield "      </div>
    ";
        }
        // line 30
        yield "  </div>";
        // line 31
        yield "</div>";
        // line 32
        yield from $this->loadTemplate("@zuvi/template-parts/footer.html.twig", "themes/contrib/zuvi/templates/layout/page--front.html.twig", 32)->unwrap()->yield($context);
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["front_sidebar", "page"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/contrib/zuvi/templates/layout/page--front.html.twig";
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
        return array (  93 => 32,  91 => 31,  89 => 30,  85 => 28,  82 => 27,  79 => 26,  77 => 25,  74 => 24,  71 => 23,  69 => 22,  64 => 21,  61 => 20,  58 => 18,  54 => 16,  52 => 15,  48 => 13,  46 => 12,  44 => 11,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/contrib/zuvi/templates/layout/page--front.html.twig", "/var/www/html/web/themes/contrib/zuvi/templates/layout/page--front.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 11, "if" => 15];
        static $filters = ["escape" => 21];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['include', 'if'],
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
