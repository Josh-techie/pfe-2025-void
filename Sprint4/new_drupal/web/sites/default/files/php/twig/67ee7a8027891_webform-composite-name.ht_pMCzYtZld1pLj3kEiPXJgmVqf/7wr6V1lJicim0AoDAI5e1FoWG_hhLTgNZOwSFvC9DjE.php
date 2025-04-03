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

/* modules/contrib/webform/templates/webform-composite-name.html.twig */
class __TwigTemplate_1aafbb5f630510182f3a9cd424324b03 extends Template
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
        // line 16
        if (($context["flexbox"] ?? null)) {
            // line 17
            yield "<div class=\"webform-name\">
  <div class=\"webform-flexbox\">
    ";
            // line 19
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "title", [], "any", false, false, true, 19)) {
                // line 20
                yield "      <div class=\"webform-flex webform-flex--2 webform-name__title\"><div class=\"webform-flex--container\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "title", [], "any", false, false, true, 20), "html", null, true);
                yield "</div></div>
    ";
            }
            // line 22
            yield "    ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "first", [], "any", false, false, true, 22)) {
                // line 23
                yield "      <div class=\"webform-flex webform-flex--3 webform-name__first\"><div class=\"webform-flex--container\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "first", [], "any", false, false, true, 23), "html", null, true);
                yield "</div></div>
    ";
            }
            // line 25
            yield "    ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "middle", [], "any", false, false, true, 25)) {
                // line 26
                yield "      <div class=\"webform-flex webform-flex--2 webform-name__middle\"><div class=\"webform-flex--container\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "middle", [], "any", false, false, true, 26), "html", null, true);
                yield "</div></div>
    ";
            }
            // line 28
            yield "    ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "last", [], "any", false, false, true, 28)) {
                // line 29
                yield "      <div class=\"webform-flex webform-flex--3 webform-name__last\"><div class=\"webform-flex--container\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "last", [], "any", false, false, true, 29), "html", null, true);
                yield "</div></div>
    ";
            }
            // line 31
            yield "    ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "suffix", [], "any", false, false, true, 31)) {
                // line 32
                yield "      <div class=\"webform-flex webform-flex--1 webform-name__suffix\"><div class=\"webform-flex--container\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "suffix", [], "any", false, false, true, 32), "html", null, true);
                yield "</div></div>
    ";
            }
            // line 34
            yield "    ";
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "degree", [], "any", false, false, true, 34)) {
                // line 35
                yield "      <div class=\"webform-flex webform-flex--1 webform-name__degree\"><div class=\"webform-flex--container\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "degree", [], "any", false, false, true, 35), "html", null, true);
                yield "</div></div>
    ";
            }
            // line 37
            yield "  </div>
</div>
";
        } else {
            // line 40
            yield "  ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["content"] ?? null), "html", null, true);
            yield "
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["flexbox", "content"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/webform/templates/webform-composite-name.html.twig";
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
        return array (  108 => 40,  103 => 37,  97 => 35,  94 => 34,  88 => 32,  85 => 31,  79 => 29,  76 => 28,  70 => 26,  67 => 25,  61 => 23,  58 => 22,  52 => 20,  50 => 19,  46 => 17,  44 => 16,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/webform/templates/webform-composite-name.html.twig", "/Users/void/Documents/Github Code/pfe-2025-void/Sprint4/new_drupal/web/modules/contrib/webform/templates/webform-composite-name.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 16];
        static $filters = ["escape" => 20];
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
