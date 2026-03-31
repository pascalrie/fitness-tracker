<?php

namespace App\Controller\Admin;

use App\Entity\BodyMeasurement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class BodyMeasurementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BodyMeasurement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('bodyWeight'),
            TextField::new('bmi'),
            TextField::new('fitnessEvaluation'),
            TextField::new('bodyHeight'),
            DateTimeField::new('createdAt'),
            DateTimeField::new('updatedAt'),
        ];
    }
}

