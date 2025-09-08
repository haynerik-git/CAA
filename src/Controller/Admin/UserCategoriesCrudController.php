<?php

namespace App\Controller\Admin;

use App\Entity\UserCategories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
class UserCategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserCategories::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            TextField::new('label'),
//            TextEditorField::new('description'),
            ImageField::new('img')->setBasePath('http://198.251.76.181/admin/assets/images/')->setUploadDir('assets/images/')
                ->setHelp('Only .png and .jpg'),
            AssociationField::new('userId'),
            AssociationField::new('userCategorieWords'),

        ];
    }

}
