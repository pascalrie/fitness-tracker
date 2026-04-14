<?php

namespace App\Controller\Admin;

use App\Entity\BodyMeasurement;
use App\Entity\MuscleGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class MuscleGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MuscleGroup::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenCreating()->hideWhenUpdating(),
            TextField::new('name')->setRequired(true),
            AssociationField::new('exercises')
                ->setCrudController(ExerciseCrudController::class)
                ->setFormTypeOptions(['choice_label' => 'uniqueName']),
        ];
    }
}

