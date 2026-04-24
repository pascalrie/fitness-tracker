<?php

namespace App\Controller\Admin;

use App\Entity\BodyMeasurement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            NumberField::new('bodyWeight'),
            NumberField::new('bmi')->hideWhenCreating()->hideWhenUpdating(),
            NumberField::new('fitnessEvaluation'),
            NumberField::new('bodyHeight'),
            DateTimeField::new('createdAt')->hideWhenCreating()->hideWhenUpdating(),
            DateTimeField::new('updatedAt')->hideWhenCreating()->hideWhenUpdating(),
            TextField::new('identifier')->hideWhenCreating()->hideWhenUpdating(),
        ];
    }
}

