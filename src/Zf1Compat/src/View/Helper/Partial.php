<?php
namespace Zf1Compat\View\Helper;

use Laminas\View\Helper\HelperInterface;
use Laminas\View\Helper\Partial as PartialHelper;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Renderer\RendererInterface;
use Zf1Compat\View\View;

class Partial implements HelperInterface
{
    /**
     * @var View
     */
    private $view;

    /**
     * @var RendererInterface
     */
    private $renderer;

    public function __construct($view)
    {
        $this->view = $view;
    }

    /**
     * Renders a template fragment within a variable scope distinct from the
     * calling View object. It proxies to view's render function
     *
     * @param  string|ModelInterface $name   Name of view script, or a view model
     * @param  array|object          $values Variables to populate in the view
     * @return string|\Laminas\View\Helper\Partial
     *@throws Exception\RuntimeException
     */
    public function __invoke($name = null, $values = null)
    {
        if ($values instanceof RendererInterface) {
            $values = $this->view->getVars();
        }

        $helper = new PartialHelper();
        $helper->setView($this->renderer);

        return $helper($name, $values);
    }

    /**
     * Set the View object
     *
     * @param RendererInterface $view
     * @return HelperInterface
     */
    public function setView(RendererInterface $view)
    {
        $this->renderer = $view;
    }

    /**
     * Get the View object
     *
     * @return RendererInterface
     */
    public function getView()
    {
        return $this->renderer;
    }
}
