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

/* modules/contrib/security_review/templates/run_and_review.html.twig */
class __TwigTemplate_e006bedda12fdfe414d2ee3c3c2ac97a extends Template
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
        yield "
<h3>
    ";
        // line 18
        yield t("Review results from last run @date", array("@date" =>         // line 19
($context["date"] ?? null), ));
        // line 21
        yield "</h3>
<p>
    ";
        // line 23
        yield t("Here you can review the results from the last run of the checklist. Checks
    are not always perfectly correct in their procedure and result. You can keep
    a check from running by clicking the 'Skip' link beside it. You can run the
    checklist again by expanding the fieldset above.", array());
        // line 29
        yield "</p>
<table class=\"security-review-run-and-review__table\">
    <tbody>
    ";
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["checks"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["check"]) {
            // line 33
            yield "        ";
            $context["style"] = "";
            // line 34
            yield "        ";
            if (CoreExtension::getAttribute($this->env, $this->source, $context["check"], "result", [], "any", true, true, true, 34)) {
                // line 35
                yield "            ";
                $context["style"] = ((($context["style"] ?? null) . " ") . CoreExtension::getAttribute($this->env, $this->source, $context["check"], "result", [], "any", false, false, true, 35));
                // line 36
                yield "        ";
            }
            // line 37
            yield "        ";
            if (CoreExtension::getAttribute($this->env, $this->source, $context["check"], "skipped", [], "any", false, false, true, 37)) {
                // line 38
                yield "            ";
                $context["style"] = (($context["style"] ?? null) . " skipped");
                // line 39
                yield "        ";
            }
            // line 40
            yield "        <tr class=\"security-review-run-and-review__entry";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["style"] ?? null), "html", null, true);
            yield "\">
            <td class=\"security-review-run-and-review__entry-icon\">
                ";
            // line 42
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["check"], "result", [], "any", false, false, true, 42), [], "array", true, true, true, 42)) {
                // line 43
                yield "                    <img src=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($_v0 = ($context["icons"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess && in_array($_v0::class, CoreExtension::ARRAY_LIKE_CLASSES, true) ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, $context["check"], "result", [], "any", false, false, true, 43)] ?? null) : CoreExtension::getAttribute($this->env, $this->source, ($context["icons"] ?? null), CoreExtension::getAttribute($this->env, $this->source, $context["check"], "result", [], "any", false, false, true, 43), [], "array", false, false, true, 43)), "html", null, true);
                yield "\"/>
                ";
            }
            // line 45
            yield "            </td>
            <td>";
            // line 46
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["check"], "message", [], "any", false, false, true, 46), "html", null, true);
            yield "</td>
            <td>";
            // line 47
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["check"], "help_link", [], "any", false, false, true, 47), "html", null, true);
            yield "</td>
            <td class=\"security-review-toggle-link\">";
            // line 48
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["check"], "toggle_link", [], "any", false, false, true, 48), "html", null, true);
            yield "</td>
        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['check'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 51
        yield "    </tbody>
</table>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["date", "checks", "icons"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/security_review/templates/run_and_review.html.twig";
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
        return array (  124 => 51,  115 => 48,  111 => 47,  107 => 46,  104 => 45,  98 => 43,  96 => 42,  90 => 40,  87 => 39,  84 => 38,  81 => 37,  78 => 36,  75 => 35,  72 => 34,  69 => 33,  65 => 32,  60 => 29,  55 => 23,  51 => 21,  49 => 19,  48 => 18,  44 => 16,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/security_review/templates/run_and_review.html.twig", "/Users/void/Documents/Github Code/pfe-2025-void/Sprint4/new_drupal/web/modules/contrib/security_review/templates/run_and_review.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["trans" => 18, "for" => 32, "set" => 33, "if" => 34];
        static $filters = ["escape" => 19];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['trans', 'for', 'set', 'if'],
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
