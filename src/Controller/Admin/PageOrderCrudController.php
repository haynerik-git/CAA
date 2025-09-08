<?php

namespace App\Controller\Admin;

use App\Entity\PageOrder;
use App\Entity\UserCategories;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
class PageOrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PageOrder::class;
    }


    public function configureFields(string $pageName): iterable
    {
//        $someRepository = $this->entityManager->getRepository(UserCategories::class);

        return [
            IdField::new('order_display'),
            TextField::new('type'),
            IdField::new('targetId'),
//            TextEditorField::new('description'),
//            AssociationField::new('user'),
            AssociationField::new('page'),
            AssociationField::new('word'),
            AssociationField::new('userCategories'),
        ];
    }

}
