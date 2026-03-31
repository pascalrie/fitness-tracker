<?php

namespace App\Controller\Admin;

use App\Entity\BodyMeasurement;
use App\Entity\Workout;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class WorkoutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Workout::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('dateOfWorkout'),
            TextField::new('bodyWeight'),
            BooleanField::new('stretch'),
            AssociationField::new('executions')
                ->setCrudController(ExecutionCrudController::class),
        ];
    }
}

