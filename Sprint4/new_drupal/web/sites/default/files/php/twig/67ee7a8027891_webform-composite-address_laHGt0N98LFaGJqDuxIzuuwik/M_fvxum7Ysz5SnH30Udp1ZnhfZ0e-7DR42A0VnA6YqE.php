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

/* modules/contrib/webform/templates/webform-composite-address.html.twig */
class __TwigTemplate_65049da1de4008858854b04ed62274f4 extends Template
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
            yield "<div class=\"webform-address\">
  ";
            // line 18
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address", [], "any", false, false, true, 18)) {
                // line 19
                yield "    <div class=\"webform-flexbox webform-address__row-1\">
      <div class=\"webform-flex webform-flex--1 webform-address__address\"><div class=\"webform-flex--container\">";
                // line 20
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address", [], "any", false, false, true, 20), "html", null, true);
                yield "</div></div>
    </div>
  ";
            }
            // line 23
            yield "
  ";
            // line 24
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address_2", [], "any", false, false, true, 24)) {
                // line 25
                yield "    <div class=\"webform-flexbox webform-address__row-2\">
      <div class=\"webform-flex webform-flex--1 webform-address__address-2\"><div class=\"webform-flex--container\">";
                // line 26
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address_2", [], "any", false, false, true, 26), "html", null, true);
                yield "</div></div>
    </div>
  ";
            }
            // line 29
            yield "
  ";
            // line 30
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "city", [], "any", false, false, true, 30) || CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "state_province", [], "any", false, false, true, 30)) || CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "postal_code", [], "any", false, false, true, 30))) {
                // line 31
                yield "    <div class=\"webform-flexbox webform-address__row-3\">
      ";
                // line 32
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "city", [], "any", false, false, true, 32)) {
                    // line 33
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__city\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "city", [], "any", false, false, true, 33), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 35
                yield "      ";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "state_province", [], "any", false, false, true, 35)) {
                    // line 36
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__province\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "state_province", [], "any", false, false, true, 36), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 38
                yield "      ";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "postal_code", [], "any", false, false, true, 38)) {
                    // line 39
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__postal-code\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "postal_code", [], "any", false, false, true, 39), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 41
                yield "    </div>
  ";
            }
            // line 43
            yield "
  ";
            // line 44
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "country", [], "any", false, false, true, 44)) {
                // line 45
                yield "    <div class=\"webform-flexbox webform-address__row-4\">
      <div class=\"webform-flex webform-flex--1 webform-address__country\"><div class=\"webform-flex--container\">";
                // line 46
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "country", [], "any", false, false, true, 46), "html", null, true);
                yield "</div></div>
    </div>
  ";
            }
            // line 49
            yield "</div>
";
        } else {
            // line 51
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
        return "modules/contrib/webform/templates/webform-composite-address.html.twig";
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
        return array (  130 => 51,  126 => 49,  120 => 46,  117 => 45,  115 => 44,  112 => 43,  108 => 41,  102 => 39,  99 => 38,  93 => 36,  90 => 35,  84 => 33,  82 => 32,  79 => 31,  77 => 30,  74 => 29,  68 => 26,  65 => 25,  63 => 24,  60 => 23,  54 => 20,  51 => 19,  49 => 18,  46 => 17,  44 => 16,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/webform/templates/webform-composite-address.html.twig", "/Users/void/Documents/Github Code/pfe-2025-void/Sprint4/new_drupal/web/modules/contrib/webform/templates/webform-composite-address.html.twig");
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
