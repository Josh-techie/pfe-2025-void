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

/* modules/contrib/security_review/templates/check_evaluation.html.twig */
class __TwigTemplate_5c8b982dee44d3acb241aef929cbcdce extends Template
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
        yield "
";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["paragraphs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["paragraph"]) {
            // line 13
            yield "    <p>
        ";
            // line 14
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["paragraph"], "html", null, true);
            yield "
    </p>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['paragraph'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["items"] ?? null))) {
            // line 18
            yield "    <ul>
        ";
            // line 19
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 20
                yield "            <li>";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["item"], "html", null, true);
                yield "</li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 22
            yield "    </ul>
";
        }
        // line 24
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["hushed_items"] ?? null))) {
            // line 25
            yield "  <h3>";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Hushed Findings"));
            yield "</h3>
  <ul>
    ";
            // line 27
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["hushed_items"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["hushed_item"]) {
                // line 28
                yield "      <li>";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["hushed_item"], "html", null, true);
                yield "</li>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['hushed_item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 30
            yield "  </ul>
";
        }
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["paragraphs", "items", "hushed_items"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/security_review/templates/check_evaluation.html.twig";
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
        return array (  106 => 30,  97 => 28,  93 => 27,  87 => 25,  85 => 24,  81 => 22,  72 => 20,  68 => 19,  65 => 18,  63 => 17,  54 => 14,  51 => 13,  47 => 12,  44 => 11,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/security_review/templates/check_evaluation.html.twig", "/Users/void/Documents/Github Code/pfe-2025-void/Sprint4/new_drupal/web/modules/contrib/security_review/templates/check_evaluation.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["for" => 12, "if" => 17];
        static $filters = ["escape" => 14, "trans" => 25];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape', 'trans'],
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
