<?php

namespace App\Controller\Admin;

use App\Entity\Exercise;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ExerciseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exercise::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            TextField::new('uniqueName'),
            AssociationField::new('executions')
                ->setCrudController(ExecutionCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'identifier']),
            AssociationField::new('plans')
                ->setCrudController(PlanCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'identifier']),
            AssociationField::new('workouts')
                ->setCrudController(WorkoutCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'identifier']),
            AssociationField::new('muscleGroups')
                ->setCrudController(MuscleGroupCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'name']),
            AssociationField::new('sets')
                ->setCrudController(SetCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'identifier']),
        ];
    }
}

