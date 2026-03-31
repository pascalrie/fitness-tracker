<?php

namespace App\Controller\Admin;

use App\Entity\Execution;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ExecutionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Execution::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            IntegerField::new('repetitions'),
            AssociationField::new('exercise')
                ->setCrudController(ExerciseCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'title']),
            DatetimeField::new('createdAt'),
            IntegerField::new('weight'),
            AssociationField::new('workout')
                ->setCrudController(WorkoutCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'dateOfWorkout']),
            AssociationField::new('associatedSet')
                ->setCrudController(SetCrudController::class),
            // ->setFormTypeOptions(['choice_label' => 'title']),
        ];
    }
}
