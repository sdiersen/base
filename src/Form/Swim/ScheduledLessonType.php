<?php

namespace App\Form\Swim;

use App\Entity\Swim\ScheduledLesson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduledLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate')
            ->add('endDate')
            ->add('startTime')
            ->add('endTime')
            ->add('daysOfWeek')
            ->add('lesson')
            ->add('instructor')
            ->add('location')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ScheduledLesson::class,
        ]);
    }
}
