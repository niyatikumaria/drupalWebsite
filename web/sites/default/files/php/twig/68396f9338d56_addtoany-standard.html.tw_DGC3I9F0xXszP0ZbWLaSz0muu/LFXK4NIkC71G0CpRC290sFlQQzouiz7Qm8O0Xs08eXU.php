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

/* modules/contrib/addtoany/templates/addtoany-standard.html.twig */
class __TwigTemplate_fd65155d065a4fe2d5a2047abc3e0b2a extends Template
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
        // line 20
        if ((($context["button_setting"] ?? null) != "none")) {
            // line 21
            $context["universal_button"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                // line 22
                yield "<a class=\"a2a_dd addtoany_share\" href=\"https://www.addtoany.com/share#url=";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::urlencode(($context["link_url"] ?? null)), "html", null, true);
                yield "&amp;title=";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::urlencode(($context["link_title"] ?? null)), "html", null, true);
                yield "\">";
                // line 23
                if (($context["button_image"] ?? null)) {
                    // line 24
                    yield "<img src=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["button_image"] ?? null), "html", null, true);
                    yield "\" alt=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Share"));
                    yield "\">";
                }
                // line 26
                yield "</a>";
                yield from [];
            })())) ? '' : new Markup($tmp, $this->env->getCharset());
        }
        // line 30
        yield "<span class=\"a2a_kit a2a_kit_size_";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["buttons_size"] ?? null), "html", null, true);
        yield " addtoany_list\" data-a2a-url=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["link_url"] ?? null), "html", null, true);
        yield "\" data-a2a-title=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["link_title"] ?? null), "html", null, true);
        yield "\">";
        // line 31
        if ((($context["universal_button_placement"] ?? null) == "before")) {
            // line 32
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["universal_button"] ?? null), "html", null, true);
        }
        // line 35
        if (($context["addtoany_html"] ?? null)) {
            // line 36
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["addtoany_html"] ?? null));
        }
        // line 39
        if ((($context["universal_button_placement"] ?? null) == "after")) {
            // line 40
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["universal_button"] ?? null), "html", null, true);
        }
        // line 42
        yield "</span>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["button_setting", "link_url", "link_title", "button_image", "buttons_size", "universal_button_placement", "addtoany_html"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/addtoany/templates/addtoany-standard.html.twig";
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
        return array (  91 => 42,  88 => 40,  86 => 39,  83 => 36,  81 => 35,  78 => 32,  76 => 31,  68 => 30,  63 => 26,  56 => 24,  54 => 23,  48 => 22,  46 => 21,  44 => 20,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/addtoany/templates/addtoany-standard.html.twig", "/var/www/html/web/modules/contrib/addtoany/templates/addtoany-standard.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 20, "set" => 21];
        static $filters = ["escape" => 22, "url_encode" => 22, "t" => 24, "raw" => 36];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'set'],
                ['escape', 'url_encode', 't', 'raw'],
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
