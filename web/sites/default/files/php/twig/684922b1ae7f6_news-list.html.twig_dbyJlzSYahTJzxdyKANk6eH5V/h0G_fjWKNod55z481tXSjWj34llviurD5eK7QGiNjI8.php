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

/* modules/custom/news/templates/news-list.html.twig */
class __TwigTemplate_77fe270e406513afec8fb93634ade853 extends Template
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
        yield "<div class=\"news-list\">
  <div class=\"news-items\">
    ";
        // line 3
        if (($context["news_items"] ?? null)) {
            // line 4
            yield "      <ul>
        ";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["news_items"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["node"]) {
                // line 6
                yield "          <li>
            <a href=\"";
                // line 7
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getPath("news.detail", ["nid" => CoreExtension::getAttribute($this->env, $this->source, $context["node"], "id", [], "any", false, false, true, 7)]), "html", null, true);
                yield "\">
              ";
                // line 8
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["node"], "label", [], "any", false, false, true, 8), "html", null, true);
                yield "
            </a>
            <div class=\"news-meta\">
              <span class=\"date\">";
                // line 11
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["node"], "field_time", [], "any", false, false, true, 11), "value", [], "any", false, false, true, 11), "F j, Y, g:i a"), "html", null, true);
                yield "</span>
              <span class=\"place\">";
                // line 12
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["node"], "field_place", [], "any", false, false, true, 12), "value", [], "any", false, false, true, 12), "html", null, true);
                yield "</span>
              ";
                // line 13
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["node"], "field_news_category", [], "any", false, false, true, 13), "value", [], "any", false, false, true, 13)) {
                    // line 14
                    yield "                <span class=\"categories\">
                  ";
                    // line 15
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["node"], "field_news_category", [], "any", false, false, true, 15));
                    foreach ($context['_seq'] as $context["_key"] => $context["term"]) {
                        // line 16
                        yield "                    <span class=\"category-tag\">";
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["term"], "entity", [], "any", false, false, true, 16), "label", [], "any", false, false, true, 16), "html", null, true);
                        yield "</span>
                  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['term'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 18
                    yield "                </span>
              ";
                }
                // line 20
                yield "            </div>
          </li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['node'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 23
            yield "      </ul>
      ";
            // line 24
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["pager"] ?? null), "html", null, true);
            yield "
    ";
        } else {
            // line 26
            yield "      <p>No news available in this category.</p>
    ";
        }
        // line 28
        yield "  </div>
</div>";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["news_items", "pager"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/custom/news/templates/news-list.html.twig";
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
        return array (  120 => 28,  116 => 26,  111 => 24,  108 => 23,  100 => 20,  96 => 18,  87 => 16,  83 => 15,  80 => 14,  78 => 13,  74 => 12,  70 => 11,  64 => 8,  60 => 7,  57 => 6,  53 => 5,  50 => 4,  48 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/custom/news/templates/news-list.html.twig", "/var/www/html/web/modules/custom/news/templates/news-list.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 3, "for" => 5];
        static $filters = ["escape" => 7, "date" => 11];
        static $functions = ["path" => 7];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape', 'date'],
                ['path'],
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
