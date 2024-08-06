<?php

namespace App\Controller\Admin;

use App\Entity\VerifiedCandidate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Validator\Constraints\NotBlank;

class VerifiedCandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VerifiedCandidate::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('stage','Stage')
            ->setRequired(true)
            ->renderAsNativeWidget()
            ->setFormTypeOption('constraints', [new NotBlank(null, ' ne peut pas être vide.')]),
            
            AssociationField::new('candidate','Candidate')
            ->setRequired(true)
            ->renderAsNativeWidget()
            ->setFormTypeOption('constraints', [new NotBlank(null, ' ne peut pas être vide.')]),
            ChoiceField::new('statut')
            ->setLabel("statut")
            ->setChoices([
                'en attend' => 'en attend',
                'verifie' => 'verifie',
                'Refuse' => 'Refuse',

            ])
            ->allowMultipleChoices(false)
            
            ->setRequired(true)
            ->setFormTypeOption('constraints', [new NotBlank(['message' => ' ne doit pas être vide.'])]),
        ];
    }
    
}
