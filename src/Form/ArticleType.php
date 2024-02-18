<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Config\Tests\Builder\Fixtures\Placeholders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $dateCreation = date('d/m/Y H:i:s');

        $builder
            ->add('Titre')
            ->add('contenu')
            ->add('dateCreation')
            ->add('etat', TextType::class, [
                'attr' => [
                    'placeholder' => 'actif / désactivé',
                ],
                'required' => true,
            ])
            ->add('dateDeParution')
            ->add('auteur', EntityType::class, [
                'class' => User::class,
'choice_label' => 'fullname',
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
'choice_label' => 'titre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
