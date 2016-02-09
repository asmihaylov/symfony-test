<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller
{
    /**
     * @Route("/lists", name="list")
     */
    public function listAction()
    {
        
        // replace this example code with whatever you need
        return $this->render('list/index.html.twig');
    }
    /**
     * @Route("/list/create", name="list_create")
     */
    public function createAction(Request $request)
    {
        
        // replace this example code with whatever you need
        return $this->render('list/create.html.twig');
    }
    /**
     * @Route("/list/edit/{id}", name="list_edit")
     */
    public function editAction($id, Request $request)
    {
        
        // replace this example code with whatever you need
        return $this->render('list/edit.html.twig');
    }
    /**
     * @Route("/list/details/{id}", name="list_details")
     */
    public function detailsAction($id)
    {
        
        // replace this example code with whatever you need
        return $this->render('list/details.html.twig');
    }
}
