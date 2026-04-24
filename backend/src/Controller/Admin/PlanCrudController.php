<?php

namespace App\Controller\Admin;

use App\Entity\BodyMeasurement;
use App\Entity\Plan;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class PlanCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Plan::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            AssociationField::new('exercises')
                ->setCrudController(ExerciseCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'uniqueName']),
            NumberField::new('totalDaysOfTraining'),
            DateField::new('startDate'),
            IntegerField::new('trainingTimesAWeek'),
            IntegerField::new('split'),
            DateTimeField::new('updatedAt')->hideWhenCreating()->hideWhenUpdating(),
            BooleanField::new('active'),
            TextField::new('identifier')->hideWhenCreating()->hideWhenUpdating(),
        ];
    }
}

