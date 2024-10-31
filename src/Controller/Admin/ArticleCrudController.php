<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
{
    return [
        TextField::new('Title', 'Title'),
        TextField::new('TitleSlug', 'URL Slug'),
        TextEditorField::new('Text', 'Content'),
        DateTimeField::new('ArticleDateCreate', 'Created Date')
            ->setFormTypeOptions([
                'html5' => true,
                'data' => new \DateTime(),
            ]),
        DateTimeField::new('ArticleDatePosted', 'Posted Date')
            ->setFormTypeOptions([
                'html5' => true,
                'required' => false,
            ])
            ->setRequired(false), // Añade esta línea
        BooleanField::new('Published', 'Is Published'),
        AssociationField::new('author', 'Author')
            ->setFormTypeOptions([
                'choice_label' => 'fullname',
            ]),
        AssociationField::new('sections', 'Sections')
            ->setFormTypeOptions([
                'choice_label' => 'SectionTitle',
            ])
    ];
    }
}
