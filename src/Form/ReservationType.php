<?php

namespace App\Form;

use App\Entity\Reservation;
// use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true, 
            ])
            ->add('email',EmailType::class, [
                'required' => true
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text', 
                'required' => true,
                'format' => 'yyyy-MM-dd',
                
            ])
            ->add('type', ChoiceType::class,
             [
                
                'placeholder' => '--- choisissez votre massage ----',
                'required' => true,
                'choices'  => [
                    'massage japonais' => 'type1',
                    'Massage thailandais ' => 'type2',
                    'massage aux pierres' => 'type3',
                ],
            ])
            ->add('duree', ChoiceType::class,
            [ 
               'placeholder'  => '--- choisissez votre duree ----',
               'choices'  => [
                   'Rituel de bien-etre 30mn (45€)' => '30mn',
                   'Rituel de bien-etre 1h (80€)' => '1h',
                   'rituel de bien-etre duo 1h (150€)' => '1h',
               ],
           ])
            ->add('message',TextType::class, [
                'required' => true
            ])
            
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
