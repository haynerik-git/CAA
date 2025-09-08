<?php

namespace App\Controller\Admin;

use App\Entity\CategoriesTranslation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class CategoriesTranslationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoriesTranslation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
//            TextEditorField::new('description'),
//            AssociationField::new('categories')
            AssociationField::new('categoriesTranslation'),
            AssociationField::new('lang')
        ];
    }

}
