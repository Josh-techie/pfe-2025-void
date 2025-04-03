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

/* modules/contrib/social_auth/templates/login-with.html.twig */
class __TwigTemplate_035914cea988fbc1cf31866a9c218ec1 extends Template
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
        $context["module"] = "social-auth";
        // line 2
        yield "
";
        // line 3
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("social_auth/auth-icons"), "html", null, true);
        yield "

";
        // line 5
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["networks"] ?? null));
        foreach ($context['_seq'] as $context["id"] => $context["network"]) {
            // line 6
            yield "  ";
            if (($context["destination"] ?? null)) {
                // line 7
                yield "    ";
                $context["options"] = ["query" => ["destination" => ($context["destination"] ?? null)]];
                // line 8
                yield "  ";
            } else {
                // line 9
                yield "    ";
                $context["options"] = [];
                // line 10
                yield "  ";
            }
            // line 11
            yield "  <a class=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["module"] ?? null), "html", null, true);
            yield " auth-link\" href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["network"], "getRedirectUrl", [($context["options"] ?? null)], "method", false, false, true, 11), "toString", [], "any", false, false, true, 11), "html", null, true);
            yield "\">
    <img class=\"";
            // line 12
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["module"] ?? null), "html", null, true);
            yield " auth-icon\"
       src=\"";
            // line 13
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["network"], "getProviderLogoPath", [], "any", false, false, true, 13), "html", null, true);
            yield "\"
       alt=\"";
            // line 14
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Authenticate through @social_network_name", ["@social_network_name" => CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["network"], "getPluginDefinition", [], "any", false, false, true, 14), "social_network", [], "any", false, false, true, 14)]));
            yield "\">
  </a>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['id'], $context['network'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["networks", "destination"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/contrib/social_auth/templates/login-with.html.twig";
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
        return array (  88 => 14,  84 => 13,  80 => 12,  73 => 11,  70 => 10,  67 => 9,  64 => 8,  61 => 7,  58 => 6,  54 => 5,  49 => 3,  46 => 2,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/contrib/social_auth/templates/login-with.html.twig", "/Users/void/Documents/Github Code/pfe-2025-void/Sprint4/new_drupal/web/modules/contrib/social_auth/templates/login-with.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["set" => 1, "for" => 5, "if" => 6];
        static $filters = ["escape" => 3, "t" => 14];
        static $functions = ["attach_library" => 3];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for', 'if'],
                ['escape', 't'],
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
