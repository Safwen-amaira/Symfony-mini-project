<?php

namespace App\Controller;
use App\Entity\Library;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibraryRepository;
use Symfony\Component\HttpFoundation\Request;
#[Route('/crud/library')]

class LibraryController extends AbstractController
{
    #[Route('/create', name: 'app_library')]
    public function AddLib(ManagerRegistry $doctrine):Response
    {   
        //create instance from the class library
        $library= new Library();
        $library->setName('Library Library');
        $library->setWebsite('library.com');
        $library->setDateCreation(new \DateTime());

        //persist the object in the doctrine
        $em=$doctrine->getManager();
        $em->persist($library);
        $em->flush();
        return $this->redirectToRoute("library_list");

    }


    #[Route('/list', name: 'library_list')]
    public function list(LibraryRepository $repository): Response
    {
        $list=$repository->findAll();
        return $this->render('library/list.html.twig',
        ['list'=>$list]);
    }


       //method search an library by name
       #[Route("/search/{name}",name:'lib_crud_search')]
       public function searchByName(LibraryRepository $repository,Request $request ):Response
       {  
           $name=$request->get('name');
       
           $library=$repository->findByName($name);
           //var_dump($librarys);die();
           return $this->render('library/list.html.twig',
           ['list'=>$library]);
       }
   
       
    //method to delete a lib
    #[Route("/delete/{id}",name:"app_delete_library")]
    public function deletelibrary(Library $lib, ManagerRegistry $doctrine):Response
    {
        $em=$doctrine->getManager();
        $em->remove($lib);
        $em->flush();
        return $this->redirectToRoute("library_list");
    }


    //method to update a lib
    #[Route('/update/{id}',name:'app_update_library')]
    public function updateLib(LibraryRepository $rep, Request $request, ManagerRegistry $doctrine):Response {
     
        $id=$request->get('id');
        $lib= $rep->find($id);
        $lib->setName('amairas');

        //save this update in the DB
        $em=$doctrine->getManager();
        $em->flush();
        return  $this->redirectToRoute("library_list");
    }










}
