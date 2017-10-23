<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Konkurencja;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Konkurencja controller.
 *
 */
class KonkurencjaController extends Controller {

    /**
     * Lists all konkurencja entities.
     *
     */
    
     private function getFirstCompetitionNameAction() {
     $em = $this->getDoctrine()->getManager();
     $firstCompetition = $em->getRepository('AppBundle:Konkurencja')->findOneById(1);
     $firstCompetitionName=$firstCompetition->getNazwaP();
     
     return $firstCompetitionName;
    
 }
 
 
    public function indexAction(Request $request) {


        $em = $this->getDoctrine()->getManager();

        $konkurencja = $em->getRepository('AppBundle:Konkurencja')->findAll();

        return $this->render('konkurencja/index.html.twig', array(
                    'konkurencje' => $konkurencja,
        ));
    }

    /**
     * Creates a new konkurencja entity.
     *
     */
    public function newAction(Request $request) {


        $konkurencja = new Konkurencja();
        $form = $this->createForm('AppBundle\Form\KonkurencjaType', $konkurencja);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($konkurencja);
            $em->flush();

            return $this->redirectToRoute('konkurencja_show', array('id' => $konkurencja->getId()));
        }

        return $this->render('konkurencja/new.html.twig', array(
                    'konkurencja' => $konkurencja,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a konkurencja entity.
     *
     */
    public function showAction(Konkurencja $konkurencja) {
        $deleteForm = $this->createDeleteForm($konkurencja);

        return $this->render('konkurencja/show.html.twig', array(
                    'konkurencja' => $konkurencja,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing konkurencja entity.
     *
     */
    public function editAction(Request $request, Konkurencja $konkurencja) {
        $deleteForm = $this->createDeleteForm($konkurencja);
        $editForm = $this->createForm('AppBundle\Form\KonkurencjaType', $konkurencja);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('konkurencja_edit', array('id' => $konkurencja->getId()));
        }

        return $this->render('konkurencja/edit.html.twig', array(
                    'konkurencja' => $konkurencja,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a konkurencja entity.
     *
     */
    public function deleteAction(Request $request, Konkurencja $konkurencja) {
        $form = $this->createDeleteForm($konkurencja);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($konkurencja);
            $em->flush();
        }
        return $this->redirectToRoute('konkurencja_index');
    }

    /**
     * Creates a form to delete a konkurencja entity.
     *
     * @param Konkurencja $konkurencja The konkurencja entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Konkurencja $konkurencja) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('konkurencja_delete', array('id' => $konkurencja->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    private function getCompetitionNameAction() {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        if($konkurencjaId = $session->get('konkurencjaId')){
            $konkurencjaId=1;
        }else{
            $konkurencjaId = $session->get('konkurencjaId');
        }
    
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneById($konkurencjaId);
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP(); 

        return $konkurencjaFullName;
    }

    private function getViewTable() {

        $viewTable4 = ['Karabin czarnoprochowy', 'Pistolet czarnoprochowy', 'Pistolet snajperski', 'Karabin samopowtarzalny'];
        $viewTable3 = ['Karabin + Pistolet Standard', 'Karabin + Pistolet OPEN'];
        $viewTable2 = ['Pistolet zapłon centralny', 'Pistolet sportowy', 'Karabin dowolny', 'Karabin wojskowy 100/75m'];
        $viewTable1 = ["Strzelba OPEN", "Strzelba Standard"];
        $viewTable = [$viewTable1, $viewTable2, $viewTable3, $viewTable4];

        return $viewTable;
    }

    private function getView() {

        $view1 = 'puste';
        $view2 = 'puste';
        $view3 = 'puste';
        $view4 = 'puste';
        $view = [$view1, $view2, $view3, $view4];

        return $view;
    }

    private function getSession() {
        $session = new Session();
        return $session;
    }

    public function chooseKonkAction() {
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Konkurencja')->findAll();
        foreach ($results as $konkurencja) {
            $results['id'] = $konkurencja->getId();
            $results['nazwaP'] = $konkurencja->getNazwaP();

            $konkurencje[] = $results;
        }

        return $this->render('konkurencja/choose.html.twig', array(
                    'konkurencje' => $konkurencje,
        ));
    }

    public function newResultsAction(Request $request) {
        $session = new Session();

        if ($request->get('konkId')) {
            $konkId = $request->get('konkId');
            $session->set('konkurencjaId', $konkId);
        } else {
            $konkId = "fdvza";
        }
        if ($konkId !== null) {
            //$session->set('konkurencjaId', $konkId);
            $session->get('konkurencjaId');
        }

        $session->get('konkurencjaId');
        $em = $this->getDoctrine()->getManager();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneById($konkurencjaId);
            if(!$konkurencjaQuery){
                $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
            }
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();


        return $this->render('rezultaty/new.html.twig', array(
                    'konkId' => $konkId,
                    'konkurencja' => $konkurencja,
        ));
    }

    public function takeOneKonkAction(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $results = $em->getRepository('AppBundle:Konkurencja')->findAll();
        foreach ($results as $konkurencja) {
            $results['id'] = $konkurencja->getId();
            $results['nazwaP'] = $konkurencja->getNazwaP();

            $konkurencje[] = $results;
        }    
        
        $firstCompetition = $this->getFirstCompetitionNameAction();
        $konkId = $session->get('konkurencjaId');
        if(!$session->get('konkurencjaId')){     
        $session->set('konkurencjaId', $konkId);}
        
        if ($request->get('konkId')) {
            $konkId = $request->get('konkId');
            $session->set('konkurencjaId', $konkId); 
        } else {
            
             $rezultaties = $em->getRepository('AppBundle:Rezultaty')->findAll();
            $konkId=1;
            return $this->render('rezultaty/raports.html.twig', array(
                  
                     'rezultaty' => $rezultaties,
                    'whichView' => 2,
                    'firstCompetition'=>$firstCompetition,
                    'konkId' => $konkId, 
                    'konkurencje' => $konkurencje,
                
        ));
        }
        if ($konkId !== null) { 
           //$session->set('konkurencjaId', $konkId);
            $session->get('konkurencjaId');
        }
       
        $konkurencjaFullName = $this->getCompetitionNameAction();
        if ($request->get('konkId')) {
            $find = $request->get('konkId');
            $session->set('konkurencjaId', $find);
            
        }else{
           $find = $konkurencjaFullName; 
            
        }


        $queryFind = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $find . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC");

        $rezultaties = $queryFind->getResult();

        $viewTable = $this->getViewTable();
        $view = $this->getView();

        for ($j = 0; $j < 4; $j++) {
            $lenghtviewTable[$j] = count($viewTable[$j]);
            for ($i = 0; $i < $lenghtviewTable[$j]; $i++) {
                if (strstr($konkurencjaFullName, $viewTable[$j][$i]) != False) {
                    $view[$j] = $viewTable[$j][$i];
                }
            }
        }
        $whichView = 1;
        for ($i = 0; $i < 4; $i++) {
            if (strstr($konkurencjaFullName, $view[$i]) !== False) {
                $whichView = $i + 1;
            }
        }
        
        
        if ($request->get('newCompetitionId')){
            
        $find=$request->get('newCompetitionId');
            
            $queryFind = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $find . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC");

        $rezultaties = $queryFind->getResult();
           
       
        }
$ileWynikow=$rezultaties;
        return $this->render('rezultaty/raports.html.twig', array(
                    'rezultaty' => $rezultaties,
                    'whichView' => $whichView,
                    'competitionName' => $find,
                    'firstCompetition'=>$firstCompetition,
                    'konkId' => $konkId,    'ileWynikow'=>$ileWynikow,
                    'konkurencje' => $konkurencje,
        ));
    }

    public function findResultAction(Request $request) {

        $session = new Session();
        $em = $this->getDoctrine()->getManager();

        if ($request->get('find')) {
            $find = $request->get('find');


            $queryFind = $em->createQuery(''
                    . " SELECT r FROM AppBundle\Entity\Konkurencja r WHERE r.nazwaP LIKE '%" . $find . "%' OR r.nazwaS LIKE '%"
                    . $find . "%'");

            $rez = $queryFind->getResult();
            $res = array();
            foreach ($rez as $r) {
                $results['id'] = $r->getId();
                $results['nazwaP'] = $r->getNazwaP();
                $results['nazwaS'] = $r->getNazwaP();
                $res[] = $results;
            }


            return $this->render('konkurencja/index.html.twig', array(
                        'konkurencje' => $res,
            ));
        } else {

            $res = array();

            return $this->render('konkurencja/index.html.twig', array(
                        'konkurencje' => $res,
            ));
        }
    }

}
