<?php
namespace Zf1Compat\View;

use Mezzio\Template\TemplatePath;
use Mezzio\Template\TemplateRendererInterface;
use Laminas\View\HelperPluginManager;
use Laminas\View\Model\ViewModel;

class View
{
    private $_disabledLayout = false;

    /**
     * @var TemplateRendererInterface
     */
    private $_template;

    /**
     * @var HelperPluginManager
     */
    private $_helpers;

    public function __construct(TemplateRendererInterface $template, HelperPluginManager $helpers)
    {
        $this->_template = $template;
        $this->_helpers = $helpers;
    }

    /**
     * Set the path to view scripts/templates
     */
    public function setScriptPath(string $path): void
    {
        $this->addScriptPath($path);
    }

    public function addScriptPath(string $path): void
    {
        $this->_template->addPath($path);
    }

    /**
     * Set a base path to all view resources
     */
    public function setBasePath(string $path, string $prefix = 'Zend_View'): void
    {
        $this->addBasePath($path, $prefix);
    }

    /**
     * Add an additional base path to view resources
     */
    public function addBasePath(string $path, string $prefix = 'Zend_View'): void
    {
        $this->_template->addPath($path . '/scripts/');
    }

    /**
     * Retrieve the current script paths
     *
     * @return TemplatePath[]
     */
    public function getScriptPaths(): array
    {
        return $this->_template->getPaths();
    }

    /**
     * Overloading methods for assigning template variables as object
     * properties
     *
     * @param mixed $value
     */
    public function __set(string $key, $value): void
    {
        if (strpos($key, '_') !== 0) {
            $this->$key = $value;
            return;
        }
    }

    public function __get(string $key)
    {
        return null;
    }

    public function __isset(string $key): bool
    {
        if (strpos($key, '_') !== 0) {
            return isset($this->$key);
        }

        return false;
    }

    public function __unset(string $key): void
    {
        if (isset($this->$key)) {
            unset($this->$key);
        }
    }

    /**
     * @param mixed[] $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        $instance =  $this->_helpers->get($name);
        return call_user_func_array($instance, $arguments);
    }

    /**
     * Manual assignment of template variables, or ability to assign
     * multiple variables en masse.
     *
     * @param array<string, mixed> $variables
     * @param mixed $value
     */
    public function assign(array $variables, $value = null)
    {
        foreach ($variables as $key => $variable) {
            if (strpos($key, '_') === 0) {
                continue; // for now just skip invalid variable names
            }
            $this->$key = $variable;
        }
    }

    /**
     * Unset all assigned template variables
     */
    public function clearVars(): void
    {
        $vars   = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (strpos($key, '_') !== 0) {
                unset($this->$key);
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function getVars()
    {
        $vars   = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (strpos($key, '_') === 0) {
                unset($vars[$key]);
            }
        }

        return $vars;
    }

    public function disableLayout(): void
    {
        $this->_disabledLayout = true;
    }

    public function isDisabledLayout(): bool
    {
        return $this->_disabledLayout;
    }

    /**
     * Render the template named $name
     */
    public function render(string $name): string
    {
        $model = new ViewModel($this->getVars());
        $model->layout = false; // disable for now the layout rendering...
        return $this->_template->render($name, $model);
    }
}
