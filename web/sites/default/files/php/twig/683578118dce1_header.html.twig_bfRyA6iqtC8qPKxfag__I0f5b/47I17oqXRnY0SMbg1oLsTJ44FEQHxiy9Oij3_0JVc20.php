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

/* @zuvi/template-parts/header.html.twig */
class __TwigTemplate_b3b143eb5ee9bf309c3688d2009146f3 extends Template
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
        // line 1
        yield "<header class=\"header\">
  <div class=\"container\">
    <div class=\"header-main\">
    ";
        // line 4
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "site_branding", [], "any", false, false, true, 4)) {
            // line 5
            yield "      <div class=\"site-brand\">
        ";
            // line 6
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "site_branding", [], "any", false, false, true, 6), "html", null, true);
            yield "
      </div>
    ";
        }
        // line 9
        yield "    ";
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 9) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "search_box", [], "any", false, false, true, 9))) {
            // line 10
            yield "      <div class=\"header-main-right\">
        ";
            // line 11
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 11)) {
                // line 12
                yield "          <div class=\"mobile-menu\" aria-label=\"Main Menu\">
            <div class=\"menu-bar\">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>";
                // line 19
                yield "          <div class=\"primary-menu-wrapper\">
            <div class=\"menu-wrap\">
              <div class=\"close-mobile-menu\" aria-label=\"Close Main Menu\"><i class=\"icon-close\"></i></div>
              ";
                // line 22
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 22), "html", null, true);
                yield "
            </div><!-- /.menu-wrap -->
          </div><!-- /.primary-menu-wrapper -->
        ";
            }
            // line 26
            yield "        ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "search_box", [], "any", false, false, true, 26)) {
                // line 27
                yield "          ";
                yield from $this->loadTemplate("@zuvi/template-parts/search.html.twig", "@zuvi/template-parts/header.html.twig", 27)->unwrap()->yield($context);
                // line 28
                yield "        ";
            }
            // line 29
            yield "      </div> <!-- /.header-right -->
    ";
        }
        // line 31
        yield "    </div> <!-- /.header-main -->
  </div><!-- /.container -->
  ";
        // line 33
        if ( !($context["is_front"] ?? null)) {
            // line 34
            yield "    ";
            yield from $this->loadTemplate("@zuvi/template-parts/page_header.html.twig", "@zuvi/template-parts/header.html.twig", 34)->unwrap()->yield($context);
            // line 35
            yield "  ";
        }
        // line 36
        yield "  ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "slider", [], "any", false, false, true, 36)) {
            // line 37
            yield "    ";
            yield from $this->loadTemplate("@zuvi/template-parts/slider.html.twig", "@zuvi/template-parts/header.html.twig", 37)->unwrap()->yield($context);
            // line 38
            yield "  ";
        }
        // line 39
        yield "</header>
";
        // line 40
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "slider", [], "any", false, false, true, 40)) {
            // line 41
            yield "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1440 160\"><path fill=\"#020312\" fill-opacity=\"1\" d=\"M0,32L60,26.7C120,21,240,11,360,42.7C480,75,600,149,720,154.7C840,160,960,96,1080,74.7C1200,53,1320,75,1380,85.3L1440,96L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z\"></path></svg>
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "is_front"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@zuvi/template-parts/header.html.twig";
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
        return array (  127 => 41,  125 => 40,  122 => 39,  119 => 38,  116 => 37,  113 => 36,  110 => 35,  107 => 34,  105 => 33,  101 => 31,  97 => 29,  94 => 28,  91 => 27,  88 => 26,  81 => 22,  76 => 19,  68 => 12,  66 => 11,  63 => 10,  60 => 9,  54 => 6,  51 => 5,  49 => 4,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@zuvi/template-parts/header.html.twig", "/var/www/html/web/themes/contrib/zuvi/templates/template-parts/header.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 4, "include" => 27];
        static $filters = ["escape" => 6];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'include'],
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
