<?php

namespace Ats\UI\AppBundle\Form;

use Ats\UI\AppBundle\Form\Type\DateTimePickerType;
use Ats\UI\AppBundle\Form\Data\ProjectFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to create and manipulate projects.
 */
class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('startDate', DateTimePickerType::class, [
                'format' => 'YYYY-MM-dd'
            ])
            ->add('endDate', DateTimePickerType::class, [
                'format' => 'YYYY-MM-dd'
            ])
            ->add('vacancies', IntegerType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectFormData::class,
        ]);
    }
}
