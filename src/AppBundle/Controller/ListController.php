<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lists;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ListController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listsAction()
    {
        $user = 'anonymous';
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Unable to access this page!');
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        if ($currentUser)
        {
            $user = $currentUser->getUserName();
        }
        $list = $this->getDoctrine()
        ->getRepository('AppBundle:Lists')
        ->findAll();

        return $this->render('list/index.html.twig', array('lists' => $list, 'user' =>$user));
    }
    /**
     * @Route("/list/create", name="list_create")
     */
    public function createAction(Request $request)
    {
        $list = new Lists;

        $form = $this->createFormBuilder($list)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal'=>'Normal', 'High'=>'High'),'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
         ->add('save', SubmitType::class, array('label'=>'Create List','attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
           //get data
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $date = new\DateTime('now');

            $list->setName($name);
            $list->setCategory($category);
            $list->setDescription($description);
            $list->setPriority($priority);
            $list->setDate($date);

            $em = $this->getDoctrine()->getManager();
            $em->persist($list);
            $em->flush();

            $this->addFlash(
                'notice', 'List added'
                );
            return $this->redirectToRoute('list');
        }

        return $this->render('list/create.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/list/edit/{id}", name="list_edit")
     */
    public function editAction($id, Request $request)
    {
         $list = $this->getDoctrine()
        ->getRepository('AppBundle:Lists')
        ->find($id);

        $list->setName($list->getName());
            $list->setCategory($list->getCategory());
            $list->setDescription($list->getDescription());
            $list->setPriority($list->getPriority());
            $list->setDate($list->getDate());

        $form = $this->createFormBuilder($list)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
        ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Normal'=>'Normal', 'High'=>'High'),'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
         ->add('save', SubmitType::class, array('label'=>'Update List','attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
           //get data
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $date = new\DateTime('now');

            $em = $this->getDoctrine()->getManager();
            $list = $em->getRepository('AppBundle:Lists')->find($id);

            $list->setName($name);
            $list->setCategory($category);
            $list->setDescription($description);
            $list->setPriority($priority);
            $list->setDate($date);

            
            $em->flush();

            $this->addFlash(
                'notice', 'List updated'
                );
            return $this->redirectToRoute('list');
        }

        return $this->render('list/edit.html.twig', array('list' => $list, 'form'=>$form->createView()));
    }
    /**
     * @Route("/list/details/{id}", name="list_details")
     */
    public function detailsAction($id)
    {
        $list = $this->getDoctrine()
        ->getRepository('AppBundle:Lists')
        ->find($id);
        // replace this example code with whatever you need
        return $this->render('list/details.html.twig', array('list' => $list));
    }
    /**
     * @Route("/list/delete/{id}", name="list_delete")
     */
    public function deleteAction($id)
    {
       $em = $this->getDoctrine()->getManager();
       $list = $em->getRepository('AppBundle:Lists')->find($id);

       $em->remove($list);
       $em->flush();
        $this->addFlash(
                'notice', 'List removed'
                );
            return $this->redirectToRoute('list');
    }
    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction()
    {
        $this->addFlash(
            'notice', 'You have successfully logged out'
        );
        return $this->redirectToRoute('/');
    }
}
