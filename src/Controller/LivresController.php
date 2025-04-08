<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LivresController extends AbstractController
{
    #[Route('/admin/livres/delete/{id}', name: 'app_livres_delete')]
    public function delete(Livres $livre, EntityManagerInterface $em): Response
{  //$livre = $rep->find($id);
    $em->remove($livre);
    $em->flush();
    dd($livre);
}




    #[Route('/admin/livres', name: 'app_livres_all')]

    public function all(LivresRepository $rep,PaginatorInterface $paginator,Request $request): Response
    {  $query=$rep->findAll();
        $livres = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );
        return $this->render('livres/all.html.twig', ['livres'=>$livres]);}



    #[Route('/admin/livres/show2', name: 'app_livres_show2')]

    public function show2(LivresRepository $rep): Response
    {  $livre=$rep->findOneBy(['titre'=>'titre 1']);
        dd($livre);}

//paramconverter
    #[Route('/admin/livres/show/{id}', name: 'app_livres_show')]

public function show(Livres $livre): Response
{
    if(!$livre)
    {throw $this->createNotFoundException("Le livre {$livre->getId()} n'existe pas.");}

    return $this->render('livres/show.html.twig', ['livre'=>$livre]);}

    #[Route('/admin/livres/create', name: 'app_livres_create')]
    public function create(EntityManagerInterface $em): Response
    { $livre=new Livres();
        $d=new \DateTime("2025-01-01");
        $livre->setTitre("titre 1")
               ->setSlug("titre-1")
               ->setIsbn("111-111-1111-1111")
               ->setImage("https://picsum.photos/200/?id=5")
               ->setResume("resumeb,dhdsfhdfhsdljflfjdlfjlkqv")
              ->setEditeur("Eyrolles")
              ->setDateEdition($d)
              ->setPrix(100);
        $em->persist($livre);
        $em->flush();
        dd($livre);



    }
}
