<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->redirect(
            $this->adminUrlGenerator
                ->setController(ExecutionCrudController::class)
                ->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Fitness-Tracker-v5');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Content Management');

        yield MenuItem::linkTo(BodyMeasurementCrudController::class, 'BodyMeasurements','fa fa-lightbulb')
            ->setAction(Action::INDEX);
        yield MenuItem::linkTo(ExerciseCrudController::class, 'Exercises', 'fa fa-folder')
            ->setAction(Action::INDEX);
        yield MenuItem::linkTo(MuscleGroupCrudController::class, 'MuscleGroups', 'fa fa-folder-open')
            ->setAction(Action::INDEX);
        yield MenuItem::linkTo(ExecutionCrudController::class, 'Executions', 'fa fa-sticky-note')
            ->setAction(Action::INDEX);
        yield MenuItem::linkTo(PlanCrudController::class, 'Plans', 'fa fa-tags')
            ->setAction(Action::INDEX);
        yield MenuItem::linkTo(SetCrudController::class, 'Sets', 'fa fa-tags')
            ->setAction(Action::INDEX);
        yield MenuItem::linkTo(WorkoutCrudController::class, 'Workouts', 'fa fa-tags')
            ->setAction(Action::INDEX);
    }
}
