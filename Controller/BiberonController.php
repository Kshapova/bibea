<?php

namespace KSH\BibeBundle\Controller;

use KSH\BibeBundle\Entity\Biberon;
use KSH\BibeBundle\Form\BiberonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BiberonController extends Controller
{
	// La route fait appel à KSHBibeBundle:Biberon:view,
  	// on doit donc définir la méthode viewAction.
  	// On donne à cette méthode l'argument $id, pour
  	// correspondre au paramètre {id} de la route
    public function viewAction($id)
    {
    	// exemple: $id vaut 5 si l'on a appelé l'URL /biberon/view/5

    	// Ici, on récupèrera depuis la base de données
    	// le biberon correspondant à l'id $id.
   		// Puis on passera le biberon à la vue pour
    	// qu'elle puisse l'afficher
        // On récupère le repository
        $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('KSHBibeBundle:Biberon');

        // On récupère l'entité correspondante à l'id $id
        $bibi = $repository->find($id);

        // $bibi est donc une instance de KSH\BibeBundle\Entity\Biberon
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $bibi) {
            throw new NotFoundHttpException("Le bibi d'id ".$id." n'existe pas.");
        }

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
      	return $this->render('KSHBibeBundle:Biberon:view.html.twig', array(
        	'bibi' => $bibi
        	)
        );

    }

    public function addAction(Request $request)
    {

        $biberon = new Biberon();

        $form = $this->createForm(new BiberonType(), $biberon);
        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($biberon);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Le biberon a été bien ajouté.');
            
            return $this->redirect($this->generateUrl('ksh_bibe_bibis', array('id' => $biberon->getId())));

        }
        return $this->render('KSHBibeBundle:Biberon:add.html.twig', array(
            'form' => $form->createView(),

        ));
       
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère le biberon $id
        $biberon = $em->getRepository('KSHBibeBundle:Biberon')->find($id);
        if (null === $biberon) {
            throw new NotFoundHttpException("Le biberon d'id ".$id." n'existe pas.");
        }
        $form = $this->createForm(new BiberonType(), $biberon);
        if ($form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre biberon
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Vos modifications ont été bien enregistrées.');
            return $this->redirect($this->generateUrl('ksh_bibe_bibis', array('id' => $biberon->getId())));
        }
        return $this->render('KSHBibeBundle:Biberon:edit.html.twig', array(
            'form'   => $form->createView(),
            'biberon' => $biberon 
        ));

    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère $id
        $biberon = $em->getRepository('KSHBibeBundle:Biberon')->find($id);
        if (null === $biberon) {
            throw new NotFoundHttpException("Le biberon d'id ".$id." n'existe pas.");
        }
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF

        // Cela permet de protéger la suppression d'annonce contre cette faille

        $form = $this->createFormBuilder()->getForm();
        if ($form->handleRequest($request)->isValid()) {
            $em->remove($biberon);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', "Le bibderon a bien été supprimé.");
            return $this->redirect($this->generateUrl('ksh_bibe_index'));
        }
        // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
        return $this->render('KSHBibeBundle:Biberon:delete.html.twig', array(
            'biberon' => $biberon,
            'form'   => $form->createView()
        ));
    }
}
