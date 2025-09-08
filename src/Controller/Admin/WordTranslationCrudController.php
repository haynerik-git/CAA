<?php

namespace App\Controller\Admin;

use App\Entity\WordTranslation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class WordTranslationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WordTranslation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
//            TextEditorField::new('description'),
//            AssociationField::new('categories')
            AssociationField::new('wordTranslation'),
            AssociationField::new('lang')
        ];
    }

}
