<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rezultaty;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use ReCaptcha\ReCaptcha;
use PHPExcel_Style_Fill;

/**
 * Rezultaty controller.
 *
 */
class RezultatyController extends Controller {

    /**
     * Lists all rezultaty entities. 
     *
     */
    private function standarizeArray() {
        
    }

    private function getCompetitionNameAction() {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();

        return $konkurencjaFullName;
    }

    private function getViewTable() {

        $viewTable4 = ['Karabin czarnoprochowy', 'Pistolet czarnoprochowy', 'Pistolet snajperski', 'Karabin samopowtarzalny'];
        $viewTable3 = ['Karabin + Pistolet Standard', 'Karabin + Pistolet OPEN'];
        $viewTable2 = ['Pistolet zapłon centralny', 'Pistolet sportowy 20 cz.', 'Karabin dowolny', 'Karabin wojskowy 100/75m'];
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

    private function getHowManyCompetitions() {

        $em = $this->getDoctrine()->getManager();
        $queryHowManyCompetitions = $em->createQuery('SELECT f FROM AppBundle\Entity\Konkurencja f');
        $ile = 0;
        $sumCompetitions = $queryHowManyCompetitions->getResult();
        foreach ($sumCompetitions as $sC) {
            $ile += 1;
        }

        return $sumCompetitions;
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();
        $queryFind = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC");
        $rezultaties = $queryFind->getResult();
        $ile = 0;

        foreach ($rezultaties as $r) {

            $ile += 1;
        }

        return $this->render('rezultaty/index.html.twig', array(
                    'rezultaty' => $rezultaties,
                    'ile' => $ile,
        ));
    }

    public function indexChooseAction() {
        $em = $this->getDoctrine()->getManager();
        $rezultaties = $em->getRepository('AppBundle:Rezultaty')->findAll();
        return $this->render('rezultaty/indexChoose.html.twig', array(
                    'rezultaty' => $rezultaties,
        ));
    }

    public function onlyViewResultsAction() {
        $em = $this->getDoctrine()->getManager();
        $konkurencjaFullName = $this->getCompetitionNameAction();
        $queryFind = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC");
        $rezultaties = $queryFind->getResult();
        $ile = 0;

        foreach ($rezultaties as $r) {
            $ile += 1;
        }

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

        return $this->render('rezultaty/onlyViewResults.html.twig', array(
                    'rezultaty' => $rezultaties,
                    'konkurencja' => $konkurencjaFullName,
                    'whichView' => $whichView,
                    'ile' => $ile,
        ));
    }

    public function raportsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $konkurencjaFullName = $this->getCompetitionNameAction();
        
        
        $queryFind = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC");

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


        return $this->render('rezultaty/raports.html.twig', array(
                    'rezultaty' => $rezultaties,
                    'whichView' => $whichView,
                    'konkurencja' => $konkurencjaFullName,
        ));
    }

    private function getCompetitionId() {
//
        if ($actualResult > $howManyResults) {
            // echo ('wiekszezf');
            echo ('totototo');
            $competitionId = rand(0, $howManyCompetitions);

            if ($competitionId >= $howManyCompetitions) {
                $competitionId = 1;
                echo('65444444444444444');
                $howManyResults = 1;
            } else {
                echo('rtyyerreeyrrrrrrrrrrrrrrrrrrr');
                $competitionId += 1;
                $actualResult = 1;
                $howManyResults = 1;
            }

            $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneById($competitionId);
            $konkurencjaFullName = $konkurencjaQuery->getNazwaP();

            $queryFind2 = $em->createQuery(''
                    . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC")
            ;

            $r2 = $queryFind2->getResult();


            foreach ($r2 as $r) {
                $howManyResults += 1;
            }
        }
//
    }

    public function autoViewResultsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getSession();
        $actualResult = 0;
        $competitionId = 1;
        $howManyResults = 1;
        if ($request->get('data1')) {
            $actualResult = (int) $request->get('data1');
        }
        if ($request->get('competitionId')) {
            $competitionId = (int) $request->get('competitionId');
        }

        $howManyCompetitions = 10;

        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneById($competitionId);
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();


        $queryFind = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC")
        ;

        $howManyR = $queryFind->getResult();


        foreach ($howManyR as $r) {
            $howManyResults += 1;
        }
        
        $actualResult += 5;
        $queryFind2 = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC")
                    ->setFirstResult($actualResult)
                    ->setMaxResults(5);

        $resul = $queryFind2->getResult();


        if ($actualResult >= $howManyResults) {

            $actualResult = 0;
            if ($competitionId < 14) {
                $competitionId += 1;
            } else {
                $competitionId = 1;
            }
            $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneById($competitionId);
            $konkurencjaFullName = $konkurencjaQuery->getNazwaP();
            $queryFind3 = $em->createQuery(''
                    . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC")
             ->setFirstResult($actualResult)
                    ->setMaxResults(5);
      // $actualResult += 2;
            $resul = $queryFind3->getResult();


            foreach ($resul as $r) {
                $howManyResults += 1;
            }
        }
        if($howManyResults<5){
            $konkurencjaFullName = $konkurencjaQuery->getNazwaP();
            $queryFind4 = $em->createQuery(''
                    . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC, f.rezultatS1 DESC, f.xS1 DESC, f.rezultatS2 DESC, f.xS2 DESC")
            ;
            $resul = $queryFind4->getResult();

            
        }
        
        
        return $this->render('rezultaty/autoViewResults.html.twig', array(
                    'rezultaty' => $resul,
                    'konkurencja' => $konkurencjaFullName,
                    'actualResult' => $actualResult,
                    'competitionId' => $competitionId,
                    'ilosc'=>$howManyResults
        ));
    }

    /**
     * Creates a new rezultaty entity.
     *
     */
    public function newAction(Request $request) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();
        $zawodnik = $this->getDoctrine()
                ->getRepository(\AppBundle\Entity\Zawodnik::class)
                ->findOneById(1);

        $rezultaty = new Rezultaty();
        $form = $this->createForm('AppBundle\Form\RezultatyType', $rezultaty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rezultaty);
            $em->flush();

            return $this->redirectToRoute('rezultaty_show', array('id' => $rezultaty->getId()));
        }

        return $this->render('rezultaty/new.html.twig', array(
                    'rezultaty' => $rezultaty,
                    'zawodnicy' => $zawodnik,
                    'konkurencja' => $konkurencja,
                    'form' => $form->createView(),
        ));
    }

    public function newEmptyViewAction(Request $request) {
        $rezultaty = new Rezultaty();
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();

        if ($request->get('luckyId')) {
            $luckyId = $request->get('luckyId');
            $session->set('luckyId', $luckyId);
        }
        if ($request->get('luckyImie')) {
            $luckyImie = $request->get('luckyImie');
            $session->set('luckyImie', $luckyImie);
        }
        if ($request->get('luckyNazwisko')) {
            $luckyNazwisko = $request->get('luckyNazwisko');
            $session->set('luckyNazwisko', $luckyNazwisko);
        }
        if ($request->get('luckyRokU')) {
            $luckyRokU = $request->get('luckyRokU');
        }
        if ($request->get('luckyNrLic')) {
            $luckyNrLic = $request->get('luckyNrLic');
        } else {
            $luckyNrLic = '0';
        }
        if ($request->get('luckyKlub')) {
            $luckyKlub = $request->get('luckyKlub');
        }

        $luckyImie = $session->get('luckyImie');
        $luckyNazwisko = $session->get('luckyNazwisko');

        $queryFind = $em->createQuery(''
                        . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' AND (f.imie='" . $luckyImie . "' AND f.nazwisko='" . $luckyNazwisko . "')")->setMaxResults(1);

        $fUsers = $queryFind->getResult();
        if (!empty($fUsers)) {

            foreach ($fUsers as $fUser) {
                $uid = $fUser->getId();
            }

            return $this->redirectToRoute('rezultaty_edit', array('konkurencja' => $konkurencja, 'id' => $uid));
        }

        $form = $this->createForm('AppBundle\Form\RezultatyType', $rezultaty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rezultaty);
            $em->flush();

            return $this->render('rezultaty/new.html.twig', array(
                        'rezultaty' => $rezultaty,
                        'konkurencja' => $konkurencja,
            ));
        } else {

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


            $array = ['id' => $rezultaty->getId(),
                'luckyId' => $luckyId,
                'luckyImie' => $luckyImie,
                'luckyNazwisko' => $luckyNazwisko,
                'luckyRokU' => $luckyRokU,
                'luckyNrLic' => $luckyNrLic,
                'luckyKlub' => $luckyKlub,
                'rezultaty' => $rezultaty,
                'form' => $form->createView(),
                'competitionFullName' => $konkurencjaFullName,
                'whichView' => $whichView,
                'konkurencja' => $konkurencja];


            if (strstr($konkurencjaFullName, $view[1]) !== False) {
                // return $this->render('rezultaty/newEmpty.html.twig', $array);
                return $this->render('rezultaty/newEmptyViewII.html.twig', $array);
            }

            if (strstr($konkurencjaFullName, $view[3]) !== False) {
                //return $this->render('rezultaty/newEmpty.html.twig', $array);
                return $this->render('rezultaty/newEmptyViewIa.html.twig', $array);
            }

            if (strstr($konkurencjaFullName, $view[0]) !== False) {
                //return $this->render('rezultaty/newEmpty.html.twig', $array);
                return $this->render('rezultaty/newEmptyViewI.html.twig', $array);
            }

            if (strstr($konkurencjaFullName, $view[2]) !== False) {
                // return $this->render('rezultaty/newEmpty.html.twig', $array);
                return $this->render('rezultaty/newEmptyViewIII.html.twig', $array);
            } else {
                return $this->render('rezultaty/newEmpty.html.twig', $array);
            }
        }
    }

    /**
     * Finds and displays a rezultaty entity.
     *
     */
    public function showAction(Rezultaty $rezultaty) {
        $deleteForm = $this->createDeleteForm($rezultaty);

        return $this->render('rezultaty/show.html.twig', array(
                    'rezultaty' => $rezultaty,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rezultaty entity.
     *
     */
    public function editAction(Request $request, Rezultaty $rezultaty) {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($rezultaty);
        $editForm = $this->createForm('AppBundle\Form\RezultatyType', $rezultaty);
        $editForm->handleRequest($request);

        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            return $this->render('rezultaty/new.html.twig', array(
                        'rezultaty' => $rezultaty,
                        'konkurencja' => $konkurencja,
            ));
        }

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

        $array = ['id' => $rezultaty->getId(),
            'rezultaty' => $rezultaty,
            'form' => $editForm->createView(),
            'competitionFullName' => $konkurencjaFullName,
            'edit_form' => $editForm->createView(),
            'konkurencja' => $konkurencja];

        if (strstr($konkurencjaFullName, $view[1]) !== False) {

            return $this->render('rezultaty/editViewII.html.twig', $array);
        }

        if (strstr($konkurencjaFullName, $view[3]) !== False) {
            return $this->render('rezultaty/editViewIa.html.twig', $array);
        }

        if (strstr($konkurencjaFullName, $view[0]) !== False) {
            return $this->render('rezultaty/editViewI.html.twig', $array);
        }

        if (strstr($konkurencjaFullName, $view[2]) !== False) {
            return $this->render('rezultaty/editViewIII.html.twig', $array);
        } else {
            return $this->render('rezultaty/edit.html.twig', array(
                        'rezultaty' => $rezultaty,
                        'edit_form' => $editForm->createView(),
                        'konkurencja' => $konkurencja,
                        'delete_form' => $deleteForm->createView(),
            ));
        }
    }

    /**
     * Deletes a rezultaty entity.
     *
     */
    public function deleteAction(Request $request, Rezultaty $rezultaty) {
        $form = $this->createDeleteForm($rezultaty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rezultaty);
            $em->flush();
        }

        return $this->redirectToRoute('rezultaty_index');
    }

    /**
     * Creates a form to delete a rezultaty entity.
     *
     * @param Rezultaty $rezultaty The rezultaty entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rezultaty $rezultaty) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('rezultaty_delete', array('id' => $rezultaty->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function findUserAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();
        $rezultaty = new Rezultaty();
        $form = $this->createForm('AppBundle\Form\RezultatyType', $rezultaty);
        $form->handleRequest($request);

        if ($request->get('find')) {
            $find = $request->get('find');

            $queryFind = $em->createQuery(''
                    . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' AND (f.imie LIKE '%" . $find . "%' OR f.nazwisko LIKE '%" . $find . "%' OR f.nrLic LIKE '%" . $find . "%' OR f.klub LIKE '%" . $find . "%' OR f.rokU LIKE '%" . $find . "%')");

            $fUsers = $queryFind->getResult();
            if (!empty($fUsers)) {

                $res = '';
                $results = array();
                foreach ($fUsers as $fUser) {
                    $results['id'] = $fUser->getId();
                    $results['imie'] = $fUser->getImie();
                    $results['nazwisko'] = $fUser->getNazwisko();
                    $results['nrLic'] = $fUser->getNrLic();
                    $results['rokU'] = $fUser->getRokU();
                    $results['klub'] = $fUser->getKlub();
                    $res[] = $results;
                }
                return $this->render('rezultaty/new.html.twig', array(
                            'konkurencje' => $konkurencjaId,
                            'res' => $res,
                            'form' => $form->createView(),));
            } elseif (empty($fUsers)) {
                if ($form->isSubmitted() && $form->isValid()) {
                    $this->getDoctrine()->getManager()->flush();
                }
                $queryFind = $em->createQuery(''
                        . " SELECT f FROM AppBundle\Entity\Zawodnik f WHERE f.imie LIKE '%" . $find . "%' OR f.nazwisko LIKE '%" . $find . "%' OR f.nrLic LIKE '%" . $find . "%' OR f.klub LIKE '%" . $find . "%' OR f.rokU LIKE '%" . $find . "%'");

                $zawodnicy = $queryFind->getResult();
                if (!empty($zawodnicy)) {

                    $res = '';
                    $results = array();
                    foreach ($zawodnicy as $fUser) {
                        $results['id'] = $fUser->getId();
                        $results['imie'] = $fUser->getImie();
                        $results['nazwisko'] = $fUser->getNazwisko();
                        $results['nrLic'] = $fUser->getNrLic();
                        $results['rokU'] = $fUser->getRokU();
                        $results['klub'] = $fUser->getKlub();
                        $res[] = $results;
                    }

                    return $this->render('zawodnik/indexChoose.html.twig', array(
                                'konkurencje' => $konkurencjaId,
                                'zawodnik' => $res,
                                'res' => $res,
                                'form' => $form->createView(),));
                }
                return $this->redirectToRoute('zawodnik_new');
            }
        } else {

            $find = '1hmgv';
            return $this->render('rezultaty/new.html.twig', array(
                        'konkurencje' => $konkurencjaId,
                        'find' => $find,
                        'form' => $form->createView(),
            ));
        }
    }

    public function findUserByIdAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');

        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();

        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();
        $rezultaty = new Rezultaty();

        $editForm = $this->createForm('AppBundle\Form\RezultatyType', $rezultaty);
        $editForm->handleRequest($request);
        if ($request->get('findById')) {
            $findById = $request->get('findById');

            $resById = $this->getDoctrine()
                    ->getRepository('AppBundle\Entity\Rezultaty')
                    ->findOneById($findById);
            $imie = $resById->getImie();
            $nazwisko = $resById->getNazwisko();
            $queryFind = $em->createQuery(''
                            . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' AND (f.imie='" . $imie . "' AND f.nazwisko='" . $nazwisko . "')")->setMaxResults(1);

            $findResByUserId = $queryFind->getResult();

            return $this->redirectToRoute('rezultaty_edit', array('konkurencja' => $konkurencja, 'id' => $findById));
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->render('rezultaty/new.html.twig', array(
                        'konkurencja' => $konkurencja,
                        'form' => $editForm->createView(),));
        } else {

            $findById = '1hmgv';
            return $this->render('rezultaty/new.html.twig', array(
                        'findById' => $findById,
                        'konkurencje' => $konkurencjaId,
                        'form' => $editForm->createView(),
            ));
        }
    }

    public function findResultAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();

        if ($request->get('find') && $request->get('filtr')) {
            $find = $request->get('find');
            $filtr = $request->get('filtr');
            $res2 = array();
            $queryFind2 = $em->createQuery(''
                    . " SELECT r FROM AppBundle\Entity\Rezultaty r WHERE r.nazwaP='" . $konkurencjaFullName . "' AND r." . $filtr . "='" . $find . "'");

            $rez2 = $queryFind2->getResult();

            foreach ($rez2 as $r2) {
                $results2['id'] = $r2->getId();
                $results2['imie'] = $r2->getImie();
                $results2['nazwisko'] = $r2->getNazwisko();
                $results2['nrLic'] = $r2->getNrLic();
                $results2['rokU'] = $r2->getRokU();
                $results2['klub'] = $r2->getKlub();
                $results2['rezultatS1'] = $r2->getRezultatS1();
                $results2['xS1'] = $r2->getXS1();
                $results2['rezultatS2'] = $r2->getRezultatS2();
                $results2['xS2'] = $r2->getXS2();
                $results2['czas'] = $r2->getczas();
                $results2['factor2'] = $r2->getFactor2();
                $results2['uwagiS1'] = $r2->getUwagiS1();
                $results2['uwagiS2'] = $r2->getUwagiS2();
                $results2['nazwaP'] = $r2->getNazwaP();
                $results2['sumaRez'] = $r2->getSumaRez();
                $results2['sumaX'] = $r2->getSumaX();
                $res2[] = $results2;
            }

            return $this->render('rezultaty/index.html.twig', array(
                        'rezultaty' => $res2,));
        }
        $res2 = array();
        if ($request->get('find')) {
            $find = $request->get('find');

            $queryFind = $em->createQuery(''
                    . " SELECT r FROM AppBundle\Entity\Rezultaty r WHERE r.nazwaP='" . $konkurencjaFullName . "' AND (r.sumaX LIKE '%" . $find . "%' OR r.sumaRez LIKE '%"
                    . $find . "%' OR r.nazwaP LIKE '%" . $find . "%' OR r.uwagiS2 LIKE '%"
                    . $find . "%' OR r.uwagiS1 LIKE '%" . $find . "%' OR r.factor2 LIKE '%"
                    . $find . "%' OR r.czas LIKE '%" . $find . "%' OR r.xS2 LIKE '%"
                    . $find . "%' OR r.rezultatS2 LIKE '%" . $find . "%' OR r.xS1 LIKE '%"
                    . $find . "%' OR r.rezultatS1 LIKE '%" . $find . "%' OR r.imie LIKE '%"
                    . $find . "%' OR r.nazwisko LIKE '%" . $find . "%' OR r.nrLic LIKE '%"
                    . $find . "%' OR r.klub LIKE '%" . $find . "%' OR r.rokU LIKE '%"
                    . $find . "%')");

            $rez = $queryFind->getResult();

            foreach ($rez as $r) {
                $results['id'] = $r->getId();
                $results['imie'] = $r->getImie();
                $results['nazwisko'] = $r->getNazwisko();
                $results['nrLic'] = $r->getNrLic();
                $results['rokU'] = $r->getRokU();
                $results['klub'] = $r->getKlub();
                $results['rezultatS1'] = $r->getRezultatS1();
                $results['xS1'] = $r->getXS1();
                $results['rezultatS2'] = $r->getRezultatS2();
                $results['xS2'] = $r->getXS2();
                $results['czas'] = $r->getCzas();
                $results['factor2'] = $r->getFactor2();
                $results['uwagiS1'] = $r->getUwagiS1();
                $results['uwagiS2'] = $r->getUwagiS2();
                $results['nazwaP'] = $r->getNazwaP();
                $results['sumaRez'] = $r->getSumaRez();
                $results['sumaX'] = $r->getSumaX();
                $res2[] = $results;
            }
            return $this->render('rezultaty/index.html.twig', array(
                        'rezultaty' => $res2,
            ));
        } else {

            $res2 = 'Brak wyników';

            return $this->render('rezultaty/index.html.twig', array(
                        'rezultaty' => $res2,
            ));
        }
    }

    public function mysubmitedAction(Request $request) {
        $recaptcha = new ReCaptcha('6Ld8STEUAAAAACrXJ_W85091yZFThQrmfE2ru68y');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());

        if (!$resp->isSuccess()) {
            $message = "The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")";
        } else {
            
        }
    }

    public function newResByIdAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');

        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();
        $rezultaty = new Rezultaty();

        if ($request->get('findById')) {
            $findById = $request->get('findById');
        }
        $resById = $this->getDoctrine()
                ->getRepository('AppBundle\Entity\Zawodnik')
                ->findOneById($findById);
        $form = $this->createForm('AppBundle\Form\RezultatyType', $rezultaty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rezultaty);
            $em->flush();

            return $this->redirectToRoute('rezultaty_new', array('id' => $rezultaty->getId()));
        }

        return $this->render('rezultaty/new.html.twig', array(
                    'zawodnik' => $resById,
                    'rezultaty' => $rezultaty,
                    'form' => $form->createView(),
        ));
    }

    public function excelAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencjaFullName = $konkurencjaQuery->getNazwaP();
        $konkS = $konkurencjaQuery->getNazwaS();
        $queryFind = $em->createQuery(''
                . " SELECT f FROM AppBundle\Entity\Rezultaty f WHERE f.nazwaP='" . $konkurencjaFullName . "' ORDER BY f.sumaRez DESC, f.sumaX DESC");

        $rezultaties = $queryFind->getResult();

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
//  $phpExcelObject->getActiveSheet()->getStyle('A1:P1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//  $phpExcelObject->getActiveSheet()->getStyle('A1:P1')->getFill()->getStartColor()->setARGB('29bb04');

        $i = 0;
        $sR = 0;
        foreach ($rezultaties as $r) {
            
        }

        $phpExcelObject->getProperties()->setCreator("")
                ->setLastModifiedBy("")
                ->setTitle("")
                ->setSubject("Konkurencja")
                ->setDescription("")
                ->setKeywords("")
                ->setCategory("Test result file");

        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A1', 'Lp.');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B1', 'Imię');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C1', 'Nazwisko');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('D1', 'RokU');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('E1', 'NrLic');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('F1', 'Klub');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('G1', 'Konkurencja');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('H1', 'Rez S1');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('I1', 'X s1');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('J1', 'Rez S2');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('K1', 'X s2');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('L1', 'Czas');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('M1', 'Factor2');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('N1', 'UwagiS1');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('O1', 'UwagiS2');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('P1', 'Suma rez');
        $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Q1', 'Suma X');

        $i = 1;
        $lp = 0;
        foreach ($rezultaties as $r) {

            $i += 1;
            $lp += 1;

            $imieExcel = $r->getImie();
            $nazwiskoExcel = $r->getNazwisko();
            $rokUExcel = $r->getRokU();
            $NrLicExcel = $r->getNrLic();
            $KlubExcel = $r->getKlub();
            $konkurencjaExcel = $r->getNazwaP();
            $rS1Excel = $r->getRezultatS1();
            $xS1Excel = $r->getXS1();
            $rS2Excel = $r->getRezultatS2();
            $xS2Excel = $r->getXS2();
            $f1Excel = $r->getCzas();
            $f2Excel = $r->getFactor2();
            $uS1Excel = $r->getUwagiS1();
            $uS2Excel = $r->getUwagiS2();
            $sumRExcel = $r->getSumaRez();
            $sumXExcel = $r->getSumaX();

            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('A' . $i, $lp);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('B' . $i, $imieExcel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('C' . $i, $nazwiskoExcel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('D' . $i, $rokUExcel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('E' . $i, $NrLicExcel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('F' . $i, $KlubExcel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('G' . $i, $konkurencjaExcel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('H' . $i, $rS1Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('I' . $i, $xS1Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('J' . $i, $rS2Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('K' . $i, $xS2Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('L' . $i, $f1Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('M' . $i, $f2Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('N' . $i, $uS1Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('O' . $i, $uS2Excel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('P' . $i, $sumRExcel);
            $phpExcelObject->setActiveSheetIndex(0)->setCellValue('Q' . $i, $sumXExcel);
        }

        $phpExcelObject->getActiveSheet()->setTitle('Rez ' . $konkS);
        $phpExcelObject->setActiveSheetIndex(0);
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'konkurencjaExcel.csv'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

}
