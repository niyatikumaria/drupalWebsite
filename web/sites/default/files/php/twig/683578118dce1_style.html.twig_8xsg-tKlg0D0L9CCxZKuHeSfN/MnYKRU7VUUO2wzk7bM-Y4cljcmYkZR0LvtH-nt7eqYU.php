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

/* @zuvi/template-parts/style.html.twig */
class __TwigTemplate_b1ce3d9a159293412a41656c00dbb6d4 extends Template
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
        yield "<style>
  @media (min-width: 1200px) {
  .container {
    max-width: ";
        // line 4
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["container_width"] ?? null), "html", null, true);
        yield "px;
  }
}
";
        // line 8
        if ((($context["header_width"] ?? null) == "header_width_full")) {
            // line 9
            yield ".header .container,
.page-header .container {
  width: 100%;
  max-width: 100%;
}
";
        }
        // line 15
        if ((($context["main_width"] ?? null) == "main_width_full")) {
            // line 16
            yield ".main-wrapper .container {
  width: 100%;
  max-width: 100%;
}
";
        }
        // line 21
        yield "
";
        // line 22
        if ((($context["footer_width"] ?? null) == "footer_width_full")) {
            // line 23
            yield ".footer .container {
  width: 100%;
  max-width: 100%;
}
";
        }
        // line 28
        if (($context["highlight_author_comment"] ?? null)) {
            // line 29
            yield ".comment-by-author {
  box-shadow: 0 0 3px var(--color-primary);
}
";
        }
        // line 33
        yield "</style>";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["container_width", "header_width", "main_width", "footer_width", "highlight_author_comment"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@zuvi/template-parts/style.html.twig";
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
        return array (  94 => 33,  88 => 29,  86 => 28,  79 => 23,  77 => 22,  74 => 21,  67 => 16,  65 => 15,  57 => 9,  55 => 8,  49 => 4,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@zuvi/template-parts/style.html.twig", "/var/www/html/web/themes/contrib/zuvi/templates/template-parts/style.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 8];
        static $filters = ["escape" => 4];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
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
