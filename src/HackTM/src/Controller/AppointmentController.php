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
use Dot\User\Options\MessagesOptions;
use Dot\User\Options\UserOptions;
use Oradea\HackTM\Entity\AppointmentEntity;
use Oradea\HackTM\Service\HackTmService;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
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
    
    protected $defaultCleanOptions = [
        'intKeys' => ['venue', 'venueId'],
        'dateKeys' => ['date'],
        'dateTimeKeys' => ['appointmentDate'],
    ];

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

    public function bookAction()
    {
        $redirUrl = '/map';
        // this is for testing redirects + flash messages
        $cleanQuery = $this->service->getCleanQuery($this->request);

        $currentRoute = $this->routeHelper->generateUri([]);
        $appointmentUnavailableUrl = $currentRoute->__toString().'?'.http_build_query($cleanQuery);
        //$redirUrl = $appointmentUnavailableUrl;

        if ($this->request->getMethod() == 'POST') {
            if (!$this->authentication()->hasIdentity()) {
                $this->messenger()->addError($this->userOptions->getMessagesOptions()
                    ->getMessage(MessagesOptions::UNAUTHORIZED));
                return new RedirectResponse($this->routeHelper
                    ->generateUri($this->webAuthenticationOptions->getLoginRoute()));
            }
            $currentUser = $this->authentication()->getIdentity();
            $userId = $currentUser->getId();

            $post = $post = $this->request->getParsedBody();
            $cleanPost = $this->service->cleanArray($post, $this->defaultCleanOptions);

            $venue = $this->service->getVenueById($cleanPost['venue']);
            if ($venue === null) {
                $this->messenger()->addError('Venue not found');
                return new RedirectResponse($redirUrl);
            }


            if (!$this->service->isDateTimeAvailable($venue, $cleanPost['appointmentDate'] ?? '')) {
                $this->messenger()->addError('Already booked');
                return new RedirectResponse($appointmentUnavailableUrl);
            }
            // date is available
            $appointment = new AppointmentEntity();
            $appointment->setDate(\DateTime::createFromFormat('Y-m-d H:i:s', $cleanPost['appointmentDate']));
            $appointment->setUserId($userId);
            $appointment->setVenueId($venue['id']);
            $this->service->createAppointment($appointment);

            // reached here --> available
            exit(__FILE__ . ':' . __LINE__);
            // store booking and
        }


        if (!is_numeric($cleanQuery['venue'] ?? null)) {
            // no venue is provided
            $this->messenger()->addError('No or invalid venue provided');
            return new RedirectResponse($redirUrl);
        }
        $venue = $this->service->getVenueById($cleanQuery['venue']);
        if ($venue === null) {
            $this->messenger()->addError('Venue not found');
            return new RedirectResponse($redirUrl);
        }

        if (($cleanQuery['date'] ?? null) === null) {
            $this->messenger()->addError('Date not provided');
            return new RedirectResponse($redirUrl);
        }
        $today = date('Y-m-d');
        if ($cleanQuery['date'] <= $today) {
            $this->messenger()->addError('Date must be starting tomorrow');
            return new RedirectResponse($redirUrl);
        }



        $rawAppointments = $this->service->listAppointments($this->service->extractOptionsFromRequest($this->request));
        $formattedAppointments = $this->service->formatAppointmentsForFrontend($venue, $rawAppointments);

        $data = [
            'appointments' => $formattedAppointments,
            'query' => $cleanQuery,
            'date' => $cleanQuery['date'],
            'venue' => $venue
        ];

        return new HtmlResponse($this->template('appointment::book', $data));
    }

    public function listAction()
    {
        $options = $this->service->extractOptionsFromRequest($this->request);
        $appointments = $this->service->listAppointments($options);
        // $date = '2019-04-16 11:XX:XX';
        $date = '2019-04-16 11:00:00';
        $venue = 1;
        $isAvl = $this->service->isDateTimeAvailable($venue, $date);
        echo '<pre/>';
        \var_dump($isAvl);
        exit(__FILE__ . ':' . __LINE__);
    }
}