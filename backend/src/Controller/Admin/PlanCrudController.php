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
            IdField::new('id'),
            AssociationField::new('exercises')
                ->setCrudController(ExerciseCrudController::class),
            TextField::new('totalDaysOfTraining'),
            DateField::new('startDate'),
            TextField::new('trainingTimesAWeek'),
            TextField::new('split'),
            DateTimeField::new('updatedAt'),
            BooleanField::new('active'),
        ];
    }
}

