<?php

namespace KSH\BibeBundle\Controller;

use KSH\BibeBundle\Entity\Baby;
use KSH\BibeBundle\Form\BabyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BabyController extends Controller
{
	// La route fait appel à KSHBibeBundle:Biberon:view,
  	// on doit donc définir la méthode viewAction.
  	// On donne à cette méthode l'argument $id, pour
  	// correspondre au paramètre {id} de la route
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
    	// exemple: $id vaut 5 si l'on a appelé l'URL /biberon/view/5

    	// Ici, on récupèrera depuis la base de données
    	// le biberon correspondant à l'id $id.
   		// Puis on passera le biberon à la vue pour
    	// qu'elle puisse l'afficher
        // On récupère le repository
        $repository = $em
          ->getRepository('KSHBibeBundle:Baby');

        // On récupère l'entité correspondante à l'id $id
        $baby = $repository->find($id);

        // $baby est donc une instance de KSH\BibeBundle\Entity\Biberon
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $baby) {
            throw new NotFoundHttpException("Le baby d'id ".$id." n'existe pas.");
        }

        // On récupère la liste des biberons du bébé
        $listBiberons = $em
            ->getRepository('KSHBibeBundle:Biberon')
            ->findBy(array('baby' => $baby));

        //On recuper l'image du profil
        $image = $baby->getImageFile();

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
      	return $this->render('KSHBibeBundle:Baby:view.html.twig', array(
        	'baby' => $baby,
            'listBiberons' => $listBiberons,
            'image' => $image
        	)
        );

    }

    public function addAction(Request $request)
    {
        $baby = new Baby();

        $form = $this->createForm(new BabyType(), $baby);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($baby);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'L\'enfant a été bien ajouté.');
            
            return $this->redirect($this->generateUrl('ksh_baby_view', array('id' => $baby->getId())));
        }
        return $this->render('KSHBibeBundle:Baby:add.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère l enfant $id
        $baby = $em->getRepository('KSHBibeBundle:Baby')->find($id);
        if (null === $baby) {
            throw new NotFoundHttpException("L'enfant d'id ".$id." n'existe pas.");
        }
        $form = $this->createForm(new BabyType(), $baby);
        if ($form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre biberon
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Vos modifications ont été bien enregistrées.');
            
            return $this->redirect($this->generateUrl('ksh_baby_view', array('id' => $baby->getId())));
        }
        return $this->render('KSHBibeBundle:Baby:edit.html.twig', array(
            'form'   => $form->createView(),
            'baby' => $baby 
        ));

    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // On récupère $id
        $baby = $em->getRepository('KSHBibeBundle:Baby')->find($id);
        if (null === $baby) {
            throw new NotFoundHttpException("L'enfant d'id ".$id." n'existe pas.");
        }

        $form = $this->createFormBuilder()->getForm();
        if ($form->handleRequest($request)->isValid()) {
            $em->remove($baby);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', "Le profil d'enfant a bien été supprimé.");
            return $this->redirect($this->generateUrl('ksh_bibe_profil'));
        }
        // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
        return $this->render('KSHBibeBundle:Baby:delete.html.twig', array(
            'baby' => $baby,
            'form'   => $form->createView()
        ));
    
    }

    //Liste de bébés 
    public function profilAction()
    {
        // On récupère le repository
        $em = $this->getDoctrine()->getManager();
        $repository = $em
          ->getRepository('KSHBibeBundle:Baby');
        
          // On récupère tous les bébés
        $babies = $repository->findAll();

        // Le render ne change pas, on passait avant un tableau, maintenant un objet
        return $this->render('KSHBibeBundle:Baby:profil.html.twig', array(
            'babies' => $babies
            ) );

    }

       //Settings - Parametres de bébés 
    public function settingsAction()
    {
        return $this->render('KSHBibeBundle:Baby:settings.html.twig');

    }


    public function editImageAction($babyId)
    {
        $em = $this->getDoctrine()->getManager();
        $baby = $em->getRepository('KSHBibeBundle:Baby')->find($babyId);
        $baby->getImage()->setUrl('test.png');

        // On n'a pas besoin de persister le bébé ni l'image.
        // Rappelez-vous, ces entités sont automatiquement persistées car
        // on les a récupérées depuis Doctrine lui-même
        // On déclenche la modification
        $em->flush();
        return new Response('OK');

    }
}
