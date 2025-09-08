<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Words;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('display_order'),
            IdField::new('level'),
            TextField::new('name'),
            ImageField::new('icon')->setBasePath('http://198.251.76.181/admin/assets/images/')->setUploadDir('assets/images/'),
            AssociationField::new('wordCategories')->setFormTypeOption('by_reference', false),
            AssociationField::new('parentCategories')->setFormTypeOption('by_reference', false),
            AssociationField::new('categoriesTranslations')->setFormTypeOption('by_reference', false),
            AssociationField::new('sentences')->setFormTypeOption('by_reference', false),
//            TextEditorField::new('description'),
        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('wordCategories')
            ;
    }
}
