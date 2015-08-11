<?php

namespace KSH\BibeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ACSEO\Bundle\GraphicBundle\Graphic\Flot\Type\TimeLine; 


class FrontController extends Controller
{
    public function indexAction()
    {
        // Pour récupérer la liste de toutes les annonces : on utilise findAll()
        // On récupère le repository
        $em = $this->getDoctrine()->getManager();
        $repository = $em
          ->getRepository('KSHBibeBundle:Baby');
        
          // On récupère tous les bébés
        $babies = $repository->findAll();
        
        $repositoryBiberons = $em
          ->getRepository('KSHBibeBundle:Biberon');
        
        $today = new \Datetime();

        foreach ($babies as $baby) {
            $id = $baby->getId();
            $nbbiberonstoday[$id] = $repositoryBiberons->findByDateBabyNbBiberons($id, $today); 
            $lastbibi[$id] = $repositoryBiberons->findByBabyLastBiberon($id);
            $bibisjour[$id] = $repositoryBiberons->findAllByIdBiberonsVolumeDate($id);
            $followersNbBibi = array();
            $followersVolume = array();
            foreach ($bibisjour[$id] as $oneday) {
                $time = $oneday['day'].'.'.$oneday['month'].'.'.$oneday['year'];
                $followerNbBibi = array(strtotime($time) * 1000, $oneday['bibis']);
                $followerVolume = array(strtotime($time) * 1000, $oneday['volume']);
                $followersNbBibi[] = $followerNbBibi; //Nombre de biberons par jour
                $followersVolume[] = $followerVolume; //Volume consomé par jour
            }
               
            $timelineNbBibiId = "#domIdFollowersNbBibi".$id;
            $timelineVolumeId = "#domIdFollowersVolume".$id;
            $timeline = new TimeLine($timelineNbBibiId, $followersNbBibi); 
            $timelinesNbBibi[$id] = $timeline;

            $timeline = new TimeLine($timelineVolumeId, $followersVolume); 
            $timelinesVolume[$id] = $timeline;

        }
        

        // L'appel de la vue ne change pas
        return $this->render('KSHBibeBundle:Front:index.html.twig', array(
          'babies' => $babies,
          'nbbiberonstoday' => $nbbiberonstoday,
          'lastbibi' => $lastbibi,
          'timelinesNbBibi' => $timelinesNbBibi,
          'timelinesVolume' => $timelinesVolume,
          'bibisjour' => $bibisjour
        ));

    }
    public function bibisAction()
    {
        // Pour récupérer la liste de toutes les annonces : on utilise findAll()
        // On récupère le repository
        $em = $this->getDoctrine()->getManager();
        $repository = $em
          ->getRepository('KSHBibeBundle:Baby');
        
          // On récupère tous les bébés
        $babies = $repository->findAll();
        
        $repositoryBiberons = $em
          ->getRepository('KSHBibeBundle:Biberon');
        $today = new \Datetime();

        foreach ($babies as $baby) {
            $id = $baby->getId();
            $biberons[$id] = $baby->getBiberons(); 
            foreach ($biberons[$id] as $bibi) {
              $biberonsmanage[$id][$bibi->getId()] = array ( 
                        'edit' => $this->generateUrl('ksh_bibe_edit', array('id' => $bibi->getId())),
                        'delete' => $this->generateUrl('ksh_bibe_delete', array('id' => $bibi->getId())),
                        ); 
            } 
            $nbbiberonstoday[$id] = $repositoryBiberons->findByDateBabyNbBiberons($id, $today); 
            $lastbibi[$id] = $repositoryBiberons->findByBabyLastBiberon($id);
        }

        // L'appel de la vue ne change pas
        return $this->render('KSHBibeBundle:Front:bibis.html.twig', array(
          'babies' => $babies,
          'biberons' => $biberons,
          'nbbiberonstoday' => $nbbiberonstoday,
          'lastbibi' => $lastbibi,
          'biberonsmanage' => $biberonsmanage,
        ));

    }
}
