<?php

namespace App\Controller\Admin;

use App\Entity\UserCategorieWords;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
class UserCategorieWordsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserCategorieWords::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('word'),
            AssociationField::new('categorie'),
            ImageField::new('img')->setBasePath('http://198.251.76.181/admin/assets/images/')->setUploadDir('assets/images/')
                ->setHelp('Only .png and .jpg'),

//            IdField::new('id'),
//            TextField::new('title'),
//            TextEditorField::new('description'),
        ];
    }

}
