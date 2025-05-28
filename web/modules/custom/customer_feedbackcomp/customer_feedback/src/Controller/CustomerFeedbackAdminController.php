<?php

namespace Drupal\customer_feedback\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\customer_feedback\Entity\CustomerFeedback;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CustomerFeedbackAdminController extends ControllerBase
{

    protected $entityTypeManager;
    protected $requestStack;

    public function __construct(EntityTypeManagerInterface $entityTypeManager, RequestStack $requestStack)
    {
        $this->entityTypeManager = $entityTypeManager;
        $this->requestStack = $requestStack;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('entity_type.manager'),
            $container->get('request_stack')
        );
    }

    public function list()
    {
        $storage = $this->entityTypeManager->getStorage('customer_feedback');
        $query = $storage->getQuery()
            ->sort('created', 'ASC')
            ->accessCheck(true);

        $status = $this->requestStack->getCurrentRequest()->query->get('status');
        if ($status && in_array($status, ['pending', 'approved', 'rejected'])) {
            $query->condition('status', $status);
        }

        $ids = $query->execute();
        $feedbacks = $storage->loadMultiple($ids);

        $rows = [];
        foreach ($feedbacks as $feedback) {
            $rows[] = [
                'id' => $feedback->id(),
                'name' => $feedback->get('name')->value,
                'email' => $feedback->get('email')->value,
                'status' => $feedback->get('status')->value,
                'created' => \Drupal::service('date.formatter')->format($feedback->get('created')->value),
                'operations' => [
                    'data' => [
                        '#type' => 'dropbutton',
                        '#links' => [
                            'view' => [
                                'title' => $this->t('View'),
                                'url' => Url::fromRoute('entity.customer_feedback.canonical', ['customer_feedback' => $feedback->id()]),
                            ],
                            'approve' => [
                                'title' => $this->t('Approve'),
                                'url' => Url::fromRoute('customer_feedback.approve', ['customer_feedback' => $feedback->id()]),
                            ],
                            'reject' => [
                                'title' => $this->t('Reject'),
                                'url' => Url::fromRoute('customer_feedback.reject', ['customer_feedback' => $feedback->id()]),
                            ],
                        ],
                    ],
                ],
            ];
        }

        $build['table'] = [
            '#type' => 'table',
            '#header' => [
                $this->t('ID'),
                $this->t('Name'),
                $this->t('Email'),
                $this->t('Status'),
                $this->t('Submitted'),
                $this->t('Operations'),
            ],
            '#rows' => $rows,
            '#empty' => $this->t('No feedback submissions found.'),
        ];

        return $build;
    }

    public function approve(CustomerFeedback $customer_feedback)
    {
        $customer_feedback->set('status', 'approved')->save();
        $this->messenger()->addStatus($this->t('Feedback has been approved.'));
        return $this->redirect('customer_feedback.admin');
    }

    public function reject(CustomerFeedback $customer_feedback)
    {
        $customer_feedback->set('status', 'rejected')->save();
        $this->messenger()->addStatus($this->t('Feedback has been rejected.'));
        return $this->redirect('customer_feedback.admin');
    }

}
