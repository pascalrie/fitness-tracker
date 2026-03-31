<?php

namespace App\Controller\Admin;

use App\Entity\BodyMeasurement;
use App\Entity\Exercise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class ExerciseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exercise::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('uniqueName'),
            AssociationField::new('executions')
                ->setCrudController(ExecutionCrudController::class),
            AssociationField::new('plans')
                ->setCrudController(PlanCrudController::class),
            AssociationField::new('workouts')
                ->setCrudController(WorkoutCrudController::class),
            AssociationField::new('muscleGroups')
                ->setCrudController(MuscleGroupCrudController::class),
            AssociationField::new('sets')
                ->setCrudController(SetCrudController::class),
        ];
    }
}

