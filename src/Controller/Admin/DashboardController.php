<?php

namespace App\Controller\Admin;

use App\Entity\WordTranslation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Word;
use App\Entity\Lang;
use App\Entity\UserCategories;
use App\Entity\UserCategorieWords;
use App\Entity\Categories;
use App\Entity\CategoriesTranslation;
use App\Entity\Sentences;
use App\Entity\SentencesTranslation;
use App\Entity\Page;
use App\Entity\PageOrder;
use App\Entity\User;
//use App\Entity\User;
//use App\Entity\UserCategories;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // Option 1. Make your dashboard redirect to the same page for all users
        return $this->redirect($adminUrlGenerator->setController(CategoriesCrudController::class)->generateUrl());

        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Config'),
                MenuItem::linkToCrud('Lang', 'fa fa-tags', Lang::class),

            MenuItem::section('Word'),
                MenuItem::linkToCrud('word', 'fa fa-tags', Word::class),
                MenuItem::linkToCrud('word User', 'fa fa-tags', UserCategorieWords::class),
                MenuItem::linkToCrud('word Translation', 'fa fa-tags', WordTranslation::class),

            MenuItem::section('Categories'),
                MenuItem::linkToCrud('Categories', 'fa fa-tags', Categories::class),
                MenuItem::linkToCrud('Categories User', 'fa fa-tags', UserCategories::class),
                MenuItem::linkToCrud('Categories Trad', 'fa fa-tags', CategoriesTranslation::class),

//            MenuItem::linkToCrud('wordTranslation', 'fa fa-tags', WordTranslation::class),
//            MenuItem::linkToCrud('Blog Posts', 'fa fa-file-text', Categories::class),
            MenuItem::section('Sentance'),
                MenuItem::linkToCrud('Sentence', 'fa fa-tags', Sentences::class),
                MenuItem::linkToCrud('Sentence Translation', 'fa fa-tags', SentencesTranslation::class),
            MenuItem::section('User'),
                MenuItem::linkToCrud('User categories', 'fa fa-tags', UserCategories::class),
                MenuItem::linkToCrud('Words', 'fa fa-tags', UserCategorieWords::class),
                MenuItem::linkToCrud('page', 'fa fa-tags', Page::class),
                MenuItem::linkToCrud('Page order', 'fa fa-tags', PageOrder::class),
                MenuItem::linkToCrud('User', 'fa fa-tags', User::class),
//                MenuItem::linkToCrud('User', 'fa fa-tags', User::class),
        ];
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
