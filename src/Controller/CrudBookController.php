<?php

namespace App\Controller;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\BookType;

#[Route('/crud/book')]


class CrudBookController extends AbstractController
{
    #[Route('/create', name: 'add_crud_book')]
    public function newBook(ManagerRegistry $doctrine):Response
    {   
       //create a new instance of book 
       $book = new Book();

       // get the book form 
       $form = $this->createForm(BookType::class, $book);
       return $this->render('crud_book/form.html.twig', array('form' => $form->createView()));

       if ($form->isSubbmitted()&&$form->isValid()) {
        $em=$doctrine->getManager();
        $em->persist($book);
        $em->flush();

       // save the book flush 

       //check if the form is valid 

    }
    }
#[Route('/list') , name('list books')]
public function getBooks(BookRepository $rep):Response {
    $list=$rep->findAll();
    return $this->render('crud_book/list.html.twig',
    ['list'=>$list]);
}



}
