<?php

namespace App\Form\Events;

use App\Entity\Events\ScheduledEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduledEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('startTime')
            ->add('endTime')
            ->add('presenter')
            ->add('location')
            ->add('event')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ScheduledEvent::class,
        ]);
    }
}
