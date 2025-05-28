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

/* themes/contrib/zuvi/templates/content/node.html.twig */
class __TwigTemplate_28c51d0f67fb134563ce528a751ac40b extends Template
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
        // line 70
        $context["node_classes"] = ["node", ((CoreExtension::getAttribute($this->env, $this->source,         // line 72
($context["node"] ?? null), "isPromoted", [], "method", false, false, true, 72)) ? ("node-promoted") : ("")), ((CoreExtension::getAttribute($this->env, $this->source,         // line 73
($context["node"] ?? null), "isSticky", [], "method", false, false, true, 73)) ? ("node-sticky") : ("")), (( !CoreExtension::getAttribute($this->env, $this->source,         // line 74
($context["node"] ?? null), "isPublished", [], "method", false, false, true, 74)) ? ("node-unpublished") : ("")), ((        // line 75
($context["view_mode"] ?? null)) ? (("node-view-mode-" . \Drupal\Component\Utility\Html::getClass(($context["view_mode"] ?? null)))) : (""))];
        // line 78
        yield "<article";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [($context["node_classes"] ?? null)], "method", false, false, true, 78), "html", null, true);
        yield ">
";
        // line 79
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["title_prefix"] ?? null), "html", null, true);
        yield "
  ";
        // line 80
        if ( !($context["page"] ?? null)) {
            // line 81
            yield "    <h2";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["title_attributes"] ?? null), "addClass", ["node-title"], "method", false, false, true, 81), "html", null, true);
            yield ">
      <a href=\"";
            // line 82
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["url"] ?? null), "html", null, true);
            yield "\" rel=\"bookmark\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true);
            yield "</a>
    </h2>
  ";
        }
        // line 85
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["title_suffix"] ?? null), "html", null, true);
        yield "

";
        // line 87
        if (($context["display_submitted"] ?? null)) {
            // line 88
            yield "  <header class=\"node-header\">
    ";
            // line 89
            if (($context["node_author_pic"] ?? null)) {
                // line 90
                yield "      <div class=\"author-picture\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["author_picture"] ?? null), "html", null, true);
                yield "</div>
    ";
            }
            // line 92
            yield "    <div";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["author_attributes"] ?? null), "addClass", ["node-submitted-details"], "method", false, false, true, 92), "html", null, true);
            yield ">
      ";
            // line 93
            $context["createdDate"] = $this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "getCreatedTime", [], "any", false, false, true, 93), "j F Y");
            // line 94
            yield "      ";
            yield t("<span><i class=\"icon-user user-icon\"></i> @author_name</span><span><i class=\"icon-calendar\"></i> @createdDate</span>", array("@author_name" => ($context["author_name"] ?? null), "@createdDate" => ($context["createdDate"] ?? null), ));
            // line 95
            yield "      ";
            if (($context["node_tags"] ?? null)) {
                // line 96
                yield "      ";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_tags", [], "any", false, false, true, 96)) {
                    // line 97
                    yield "        <span><i class=\"icon-hashtag\"></i>
        ";
                    // line 98
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_tags", [], "any", false, false, true, 98));
                    foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                        // line 99
                        yield "          ";
                        if ((($_v0 = $context["item"]) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0["#title"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, $context["item"], "#title", [], "array", false, false, true, 99))) {
                            // line 100
                            yield "            <a href=\"";
                            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($_v1 = $context["item"]) && is_array($_v1) || $_v1 instanceof ArrayAccess && in_array($_v1::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v1["#url"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, $context["item"], "#url", [], "array", false, false, true, 100)), "html", null, true);
                            yield "\">";
                            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($_v2 = $context["item"]) && is_array($_v2) || $_v2 instanceof ArrayAccess && in_array($_v2::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v2["#title"] ?? null) : CoreExtension::getAttribute($this->env, $this->source, $context["item"], "#title", [], "array", false, false, true, 100)), "html", null, true);
                            yield "</a>";
                            yield ",";
                            yield "
          ";
                        }
                        // line 102
                        yield "        ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 103
                    yield "      </span>
      ";
                }
                // line 105
                yield "      ";
            }
            // line 106
            yield "      ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["metadata"] ?? null), "html", null, true);
            yield "
    </div>
  </header>
";
        }
        // line 110
        yield "  <div";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", ["node-content"], "method", false, false, true, 110), "html", null, true);
        yield ">
    ";
        // line 111
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["content"] ?? null), "html", null, true);
        yield "
  </div>
</article>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["node", "view_mode", "attributes", "title_prefix", "page", "title_attributes", "url", "label", "title_suffix", "display_submitted", "node_author_pic", "author_picture", "author_attributes", "author_name", "node_tags", "content", "metadata", "content_attributes"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/contrib/zuvi/templates/content/node.html.twig";
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
        return array (  154 => 111,  149 => 110,  141 => 106,  138 => 105,  134 => 103,  128 => 102,  118 => 100,  115 => 99,  111 => 98,  108 => 97,  105 => 96,  102 => 95,  99 => 94,  97 => 93,  92 => 92,  86 => 90,  84 => 89,  81 => 88,  79 => 87,  74 => 85,  66 => 82,  61 => 81,  59 => 80,  55 => 79,  50 => 78,  48 => 75,  47 => 74,  46 => 73,  45 => 72,  44 => 70,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/contrib/zuvi/templates/content/node.html.twig", "/var/www/html/web/themes/contrib/zuvi/templates/content/node.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 70, "if" => 80, "trans" => 94, "for" => 98];
        static $filters = ["clean_class" => 75, "escape" => 78, "date" => 93];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if', 'trans', 'for'],
                ['clean_class', 'escape', 'date'],
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
