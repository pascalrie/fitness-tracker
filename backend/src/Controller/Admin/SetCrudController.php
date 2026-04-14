<?php

namespace App\Controller\Admin;

use App\Entity\BodyMeasurement;
use App\Entity\Set;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class SetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Set::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            AssociationField::new('exercise')
                ->setCrudController(ExerciseCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'uniqueName']),
            AssociationField::new('executions')
                ->setCrudController(ExecutionCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'id']),
            DatetimeField::new('createdAt')->hideWhenCreating()->hideWhenUpdating(),
            DatetimeField::new('updatedAt')->hideWhenCreating()->hideWhenUpdating(),
            IntegerField::new('repetitions'),
            AssociationField::new('workout')
                ->setCrudController(WorkoutCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'id']),
        ];
    }
}

