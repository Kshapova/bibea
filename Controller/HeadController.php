<?php

namespace KSH\BibeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class HeadController extends Controller
{
    public function menuAction()
    {
    	//Récupérer  le nom la route courante
    	$requestStack = $this->get('request_stack');
    	$masterRequest = $requestStack->getMasterRequest();
    	$route = null;

    	if ( $masterRequest )
    	{
    		$route = $masterRequest->attributes->get('_route');
    	}
    	$menu = array (
                'ksh_bibe_bibis' => array ( 
                            'link' => $this->generateUrl('ksh_bibe_bibis'),
                            'label' => 'Carnet de bord des repas'
                            ),  
                'ksh_bibe_add' => array ( 
                			'link' => $this->generateUrl('ksh_bibe_add'),
                			'label' => 'Ajouter un biberon'
                			),	
                'ksh_bibe_profil' => array ( 
                			'link' => $this->generateUrl('ksh_bibe_profil'),
                			'label' => 'Mes enfants'
                			),
                'ksh_bibe_settings' => array ( 
                			'link' => $this->generateUrl('ksh_bibe_settings'),
                			'label' => 'Parametres'
                			)
            ); 
        return $this->render('KSHBibeBundle:Head:menu.html.twig',
        			array ('menu' => $menu,
        				'route' => $route
        			)
        		);
    }

}
