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

/* @zuvi/template-parts/footer.html.twig */
class __TwigTemplate_cbe8f9961f883720f825672a24b1e01a extends Template
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
        yield "<footer class=\"footer full-width\">
  ";
        // line 2
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top", [], "any", false, false, true, 2)) {
            // line 3
            yield "    <section class=\"footer-top-section full-width\">
      <div class=\"container\">
        <div class=\"footer-top\">
          ";
            // line 6
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_top", [], "any", false, false, true, 6), "html", null, true);
            yield "
        </div>
      </div>
    </section>
  ";
        }
        // line 10
        yield "<!-- /footer-top -->
  ";
        // line 11
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 11) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 11)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 11)) || CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 11))) {
            // line 12
            yield "    <section class=\"footer-blocks-section full-width\">
      <div class=\"container\">
      <div class=\"footer-container\">        
        ";
            // line 15
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 15)) {
                // line 16
                yield "          <div class=\"footer-block\">
            ";
                // line 17
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_first", [], "any", false, false, true, 17), "html", null, true);
                yield "
          </div>
        ";
            }
            // line 20
            yield "        ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 20)) {
                // line 21
                yield "          <div class=\"footer-block\">          
            ";
                // line 22
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_second", [], "any", false, false, true, 22), "html", null, true);
                yield "          
          </div>
        ";
            }
            // line 25
            yield "        ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 25)) {
                // line 26
                yield "          <div class=\"footer-block\">          
            ";
                // line 27
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_third", [], "any", false, false, true, 27), "html", null, true);
                yield "          
          </div>
        ";
            }
            // line 30
            yield "        ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 30)) {
                // line 31
                yield "          <div class=\"footer-block\">          
            ";
                // line 32
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_fourth", [], "any", false, false, true, 32), "html", null, true);
                yield "          
          </div>
        ";
            }
            // line 35
            yield "      </div><!--/footer-container -->
      </div><!--/container -->
    </section> <!--/footer-blocks -->
  ";
        }
        // line 38
        yield " ";
        // line 39
        yield "  ";
        if (CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 39)) {
            // line 40
            yield "    <section class=\"footer-bottom-section full-width\">
      <div class=\"container\">
        <div class=\"footer-bottom\">
          ";
            // line 43
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 43), "html", null, true);
            yield "
        </div>
      </div>
    </section>
  ";
        }
        // line 47
        yield "<!-- /footer-bottom -->
 ";
        // line 48
        if ((($context["copyright_text"] ?? null) || ($context["all_icons_show"] ?? null))) {
            // line 49
            yield "  <section class=\"footer-bottom-last-section full-width\">
    <div class=\"container\">
      <div class=\"footer-bottom-last\">
        ";
            // line 52
            if (($context["copyright_text"] ?? null)) {
                // line 53
                yield "          <div class=\"copyright\">
            &copy; ";
                // line 54
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
                yield " ";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["site_name"] ?? null), "html", null, true);
                yield ", All rights reserved.
          </div>
        ";
            }
            // line 57
            yield "        ";
            if (($context["all_icons_show"] ?? null)) {
                // line 58
                yield "          ";
                yield from $this->loadTemplate("@zuvi/template-parts/social-icons.html.twig", "@zuvi/template-parts/footer.html.twig", 58)->unwrap()->yield($context);
                // line 59
                yield "        ";
            }
            // line 60
            yield "      </div>
    </div>
  </section>
  ";
        }
        // line 64
        yield "</footer>
";
        // line 65
        if (($context["scrolltotop_on"] ?? null)) {
            // line 66
            yield "  <div class=\"scrolltop\">
    <div class=\"scrolltop-icon\"><i class=\"icon-arrow-up\"></i></div>
  </div>
";
        }
        // line 70
        yield from $this->loadTemplate("@zuvi/template-parts/style.html.twig", "@zuvi/template-parts/footer.html.twig", 70)->unwrap()->yield($context);
        // line 71
        if (($context["fontawesome_four"] ?? null)) {
            // line 72
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("zuvi/fontawesome4"), "html", null, true);
            yield "
";
        }
        // line 74
        if (($context["fontawesome_five"] ?? null)) {
            // line 75
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("zuvi/fontawesome5"), "html", null, true);
            yield "
";
        }
        // line 77
        if (($context["bootstrapicons"] ?? null)) {
            // line 78
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("zuvi/bootstrap-icons"), "html", null, true);
            yield "
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "copyright_text", "all_icons_show", "site_name", "scrolltotop_on", "fontawesome_four", "fontawesome_five", "bootstrapicons"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@zuvi/template-parts/footer.html.twig";
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
        return array (  212 => 78,  210 => 77,  204 => 75,  202 => 74,  196 => 72,  194 => 71,  192 => 70,  186 => 66,  184 => 65,  181 => 64,  175 => 60,  172 => 59,  169 => 58,  166 => 57,  158 => 54,  155 => 53,  153 => 52,  148 => 49,  146 => 48,  143 => 47,  135 => 43,  130 => 40,  127 => 39,  125 => 38,  119 => 35,  113 => 32,  110 => 31,  107 => 30,  101 => 27,  98 => 26,  95 => 25,  89 => 22,  86 => 21,  83 => 20,  77 => 17,  74 => 16,  72 => 15,  67 => 12,  65 => 11,  62 => 10,  54 => 6,  49 => 3,  47 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@zuvi/template-parts/footer.html.twig", "/var/www/html/web/themes/contrib/zuvi/templates/template-parts/footer.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 2, "include" => 58];
        static $filters = ["escape" => 6, "date" => 54];
        static $functions = ["attach_library" => 72];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'include'],
                ['escape', 'date'],
                ['attach_library'],
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
