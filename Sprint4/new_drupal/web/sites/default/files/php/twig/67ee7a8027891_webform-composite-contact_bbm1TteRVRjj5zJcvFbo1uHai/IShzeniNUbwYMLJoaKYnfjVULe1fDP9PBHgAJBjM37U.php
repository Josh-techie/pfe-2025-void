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

/* modules/contrib/webform/templates/webform-composite-contact.html.twig */
class __TwigTemplate_53dcd7d42bd1faf1701332aa6e76d253 extends Template
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
            yield "<div class=\"webform-contact\">
  ";
            // line 18
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "name", [], "any", false, false, true, 18) || CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "company", [], "any", false, false, true, 18))) {
                // line 19
                yield "    <div class=\"webform-flexbox webform-contact__row-1\">
      ";
                // line 20
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "name", [], "any", false, false, true, 20)) {
                    // line 21
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__name\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "name", [], "any", false, false, true, 21), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 23
                yield "      ";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "company", [], "any", false, false, true, 23)) {
                    // line 24
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__company\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "company", [], "any", false, false, true, 24), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 26
                yield "    </div>
  ";
            }
            // line 28
            yield "
  ";
            // line 29
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "email", [], "any", false, false, true, 29) || CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "phone", [], "any", false, false, true, 29))) {
                // line 30
                yield "    <div class=\"webform-flexbox webform-contact__row-2\">
      ";
                // line 31
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "email", [], "any", false, false, true, 31)) {
                    // line 32
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__email\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "email", [], "any", false, false, true, 32), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 34
                yield "      ";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "phone", [], "any", false, false, true, 34)) {
                    // line 35
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__phone\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "phone", [], "any", false, false, true, 35), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 37
                yield "    </div>
  ";
            }
            // line 39
            yield "
  ";
            // line 40
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address", [], "any", false, false, true, 40)) {
                // line 41
                yield "    <div class=\"webform-flexbox webform-contact__row-3\">
      <div class=\"webform-flex webform-flex--1 webform-address__address\"><div class=\"webform-flex--container\">";
                // line 42
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address", [], "any", false, false, true, 42), "html", null, true);
                yield "</div></div>
    </div>
  ";
            }
            // line 45
            yield "
  ";
            // line 46
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address_2", [], "any", false, false, true, 46)) {
                // line 47
                yield "    <div class=\"webform-flexbox webform-contact__row-4\">
      <div class=\"webform-flex webform-flex--1 webform-address__address-2\"><div class=\"webform-flex--container\">";
                // line 48
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "address_2", [], "any", false, false, true, 48), "html", null, true);
                yield "</div></div>
    </div>
  ";
            }
            // line 51
            yield "
  ";
            // line 52
            if (((CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "city", [], "any", false, false, true, 52) || CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "state_province", [], "any", false, false, true, 52)) || CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "postal_code", [], "any", false, false, true, 52))) {
                // line 53
                yield "    <div class=\"webform-flexbox webform-contact__row-5\">
      ";
                // line 54
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "city", [], "any", false, false, true, 54)) {
                    // line 55
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__city\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "city", [], "any", false, false, true, 55), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 57
                yield "      ";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "state_province", [], "any", false, false, true, 57)) {
                    // line 58
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__province\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "state_province", [], "any", false, false, true, 58), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 60
                yield "      ";
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "postal_code", [], "any", false, false, true, 60)) {
                    // line 61
                    yield "        <div class=\"webform-flex webform-flex--1 webform-address__postal-code\"><div class=\"webform-flex--container\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "postal_code", [], "any", false, false, true, 61), "html", null, true);
                    yield "</div></div>
      ";
                }
                // line 63
                yield "    </div>
  ";
            }
            // line 65
            yield "
  ";
            // line 66
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "country", [], "any", false, false, true, 66)) {
                // line 67
                yield "    <div class=\"webform-flexbox webform-contact__row-6\">
      <div class=\"webform-flex webform-flex--1 webform-address__country\"><div class=\"webform-flex--container\">";
                // line 68
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "country", [], "any", false, false, true, 68), "html", null, true);
                yield "</div></div>
    </div>
  ";
            }
            // line 71
            yield "</div>
";
        } else {
            // line 73
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
        return "modules/contrib/webform/templates/webform-composite-contact.html.twig";
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
        return array (  188 => 73,  184 => 71,  178 => 68,  175 => 67,  173 => 66,  170 => 65,  166 => 63,  160 => 61,  157 => 60,  151 => 58,  148 => 57,  142 => 55,  140 => 54,  137 => 53,  135 => 52,  132 => 51,  126 => 48,  123 => 47,  121 => 46,  118 => 45,  112 => 42,  109 => 41,  107 => 40,  104 => 39,  100 => 37,  94 => 35,  91 => 34,  85 => 32,  83 => 31,  80 => 30,  78 => 29,  75 => 28,  71 => 26,  65 => 24,  62 => 23,  56 => 21,  54 => 20,  51 => 19,  49 => 18,  46 => 17,  44 => 16,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/webform/templates/webform-composite-contact.html.twig", "/Users/void/Documents/Github Code/pfe-2025-void/Sprint4/new_drupal/web/modules/contrib/webform/templates/webform-composite-contact.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 16];
        static $filters = ["escape" => 21];
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
