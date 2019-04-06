<?php
/**
 * Created by PhpStorm.
 * User: Mario
 * Date: 4/6/2019
 * Time: 1:30 PM
 */

namespace Oradea\HackTM\Controller;

use Doctrine\ORM\EntityManager;
use Dot\Authentication\Web\Options\WebAuthenticationOptions;
use Dot\Controller\AbstractActionController;
use Dot\Helpers\Route\RouteHelper;
use Dot\User\Event\DispatchUserControllerEventsTrait;
use Dot\User\Event\UserControllerEventListenerInterface;
use Dot\User\Event\UserControllerEventListenerTrait;
use Dot\User\Options\UserOptions;
use Oradea\HackTM\Service\HackTmService;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class AppointmentController extends AbstractActionController implements UserControllerEventListenerInterface
{
    use DispatchUserControllerEventsTrait;
    use UserControllerEventListenerTrait;
    /**
     * @var array $config
     */
    protected $config;

    /** @var HackTmService */
    protected $service;

    /**
     * @var TemplateRendererInterface $template
     */
    protected $template;

    /** @var  UserOptions */
    protected $userOptions;

    /** @var  WebAuthenticationOptions */
    protected $webAuthenticationOptions;

    /** @var  RouteHelper */
    protected $routeHelper;

    protected $entityManager;

    public function __construct(
        $config,
        HackTmService $service,
        UserOptions $userOptions,
        WebAuthenticationOptions $webAuthenticationOptions,
        RouteHelper $routeHelper,
        EntityManager $entityManager
    ) {
        $this->config = $config;
        $this->service = $service;
        $this->webAuthenticationOptions = $webAuthenticationOptions;
        $this->userOptions = $userOptions;
        $this->routeHelper = $routeHelper;
        $this->entityManager = $entityManager;
    }
    /**
     * @return ResponseInterface
     */
    public function indexAction(): ResponseInterface
    {
        exit(__FILE__ . ':' . __LINE__);
    }

    public function listAction()
    {
        $options = $this->service->extractOptionsFromRequest($this->request);
        $appointments = $this->service->listAppointments($options);
        echo '<pre/>';
        \var_dump($appointments);
        exit(__FILE__ . ':' . __LINE__);
    }
}