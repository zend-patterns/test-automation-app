<?php
namespace Zf1Compat\Handler\Traits;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Exception\RuntimeException;
use Mezzio\Router\RouteResult;
use Zf1Compat\View\View;
use Zf1Compat\View\ViewFactoryInterface;

trait ActionTrait
{
    /**
     * ZF1 compatible view
     * @var View
     */
    protected $view;
    
    /**
     * ZF1 compatible layout
     * @var View
     */
    protected $layout;

    /**
     * @var string|null
     */
    private $specialAction;
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routeParams = $this->getRouteParams($request);
        $action = @$routeParams['action'];
        
        $action = preg_replace_callback('/-([\w])/', function ($match) {
            return strtoupper($match[1]);
        }, $action);
        $actionMethod = $action.'Action';
        
        if (! method_exists($this, $actionMethod)) {
            $response = new Response();
            return $response->withStatus(404);
        }

        $viewFactory = $request->getAttribute(ViewFactoryInterface::class);

        // Create the view object...
        $this->view = $viewFactory->createView();
        
        if (method_exists($this, 'init')) {
            $this->init($request);
        }
                
        $response = $this->$actionMethod($request);
        if ($response instanceof View) {
            $view = $response;
        
            $controller = @$routeParams['controller'];
            $module = @$routeParams['module'];
            
            // setBasePath
            $viewConfig = $this->config['zf1_view'];
            if (empty($module)) {
                $module = $viewConfig['module'];
            }
            $baseDir = TEMPLATE_PATH . '/modules/'. $module.'/views/';
            if (!file_exists($baseDir) || !is_dir($baseDir)) {
                throw new \Laminas\Http\Exception\RuntimeException('Missing base or unreadable base view directory');
            }
            
            $view->addBasePath($baseDir, 'Zend_View');
            
            // Render the view
            $controller = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $controller)); // camel-case to dash
            $script = $controller . '/' . ($this->specialAction ? $this->specialAction : $action) . $viewConfig['suffix'];
            $viewFactory->injectViewVars($request, $view);
            $content = $view->render($script);
            
            // Take care for the layout too
            if (!$view->isDisabledLayout()) {
                $layout = clone $view;
                $layout->addBasePath(TEMPLATE_PATH.'/layouts');
                $layout->content = $content;
                
                $content = $layout->render($viewConfig['layout'] . $viewConfig['suffix']);
            }
            
            return new HtmlResponse($content);
        }
        
        if (!($response instanceof ResponseInterface)) {
            // IMPORTANT: the actions MUST return only instance of Zf1Compat/View/View or response objects.
            throw new RuntimeException('Invalid response!');
        }
        
        return $response;
    }
    
    /**
     * Internal forward to another action in the same class
     */
    public function forward(ServerRequestInterface $request, string $action) : Response
    {
        $params = $request->getParsedBody();
        $actionMethod = $action . 'Action';
        
        if (! method_exists($this, $actionMethod)) {
            $response = new Response();
            return $response->withStatus(404);
        }
        
        $params['action'] = $action;
        $request = $request->withParsedBody($params);
        
        return $this->$actionMethod($request);
    }
    
    /**
     * Used in ZF1 to change the view script name
     */
    public function render(ServerRequestInterface $request, string $action) : View
    {
        $this->specialAction = $action;
        
        return $this->view;
    }

    public function getRouteParams(ServerRequestInterface $request) : array
    {
        return $request
            ->getAttribute(RouteResult::class)
            ->getMatchedParams();
    }
}
