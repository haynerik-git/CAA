<?php

namespace App\Controller\Admin;

use App\Entity\Sentences;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class SentencesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sentences::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//            IdField::new('id'),
            TextField::new('name'),
            ImageField::new('filename')->setBasePath('http://198.251.76.181/admin/assets/images/')->setUploadDir('assets/images/'),
            TextEditorField::new('description'),
            IdField::new('display_order'),
            AssociationField::new('sentencesTranslations'),
            AssociationField::new('categoriesSentences'),
            AssociationField::new('sentencesWord'),
            AssociationField::new('user'),
        ];
    }

}
