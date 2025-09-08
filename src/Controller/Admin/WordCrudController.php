<?php

namespace App\Controller\Admin;

use App\Entity\Word;
use App\Controller\CategoriesCrudController;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use Symfony\Component\Validator\Constraints\File;
class WordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Word::class;
    }


    public function configureFields(string $pageName): iterable
    {
        ini_set("memory_limit", "300M");
        return [
            IdField::new('display_order'),
            TextField::new('name'),
//            TextField::new('filename'),
            ImageField::new('filename')->setBasePath('http://198.251.76.181/admin/assets/images/')->setUploadDir('assets/images/')
                ->setHelp('Only .png and .jpg')
//                ->setFormTypeOption('constraints', [
//                    new File([
//                        'maxSize' => '5M',
////                        'mimeTypes' => [
////                            'image/jpeg',
////                            'image/png',
////                        ],
//                        'mimeTypesMessage' => 'Please upload a valid image. '
//                    ])
//                ])
            ,

            AssociationField::new('categoriesWord'),
            AssociationField::new('sentences')->setFormTypeOption('by_reference', false),
            AssociationField::new('nextCategories')->setFormTypeOption('by_reference', false),
            AssociationField::new('user'),

        ];
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('categoriesWord')
            ;
    }

}
