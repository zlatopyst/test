<?php

// src/Admin/BookAdmin.php

namespace App\Admin;

use App\Repository\BookRepository;
use App\Entity\Author;
use App\Entity\Book;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class BookAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('Title', TextType::class);
		$formMapper->add('Author', ModelType::class, [
            'class' => Author::class,
            'property' => 'Name',
        ]);
        $formMapper->add('Info', TextareaType::class);
        $formMapper->add('Image', TextType::class);
		$formMapper
            ->add('Date', null,
                array(
                    'format' =>  'dd MMM yyyy' ,
                    'widget' => 'choice'
                )
            );

    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('Title');
        $datagridMapper->add('Date');
        $datagridMapper->add('Author');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('Title');
        $listMapper->addIdentifier('Date');
        $listMapper->addIdentifier('Author');
    }
}