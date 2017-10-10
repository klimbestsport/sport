<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Zawodnik;
use AppBundle\Entity\Rezultaty;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Zawodnik controller.
 *
 */
class ZawodnikController extends Controller {

    /**
     * Lists all zawodnik entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $zawodnik = $em->getRepository('AppBundle:Zawodnik')->findAll();

        $ile = 0;
        foreach ($zawodnik as $r) {

            $ile += 1;
        }

        return $this->render('zawodnik/index.html.twig', array(
                    'zawodnik' => $zawodnik,
                    'ile' => $ile,
        ));
    }

    public function indexChooseZAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $zawodnicy = $em->getRepository('AppBundle:Zawodnik')->findAll();


//        $form = $this->createForm('AppBundle\Form\RezultatyType', $rezultaty);
//        $form->handleRequest($request);
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();
        $rezultaties = new Rezultaty();
        $form = $this->createForm('AppBundle\Form\RezultatyType', $rezultaties);
        $form->handleRequest($request);
//
//            if ($form->isSubmitted() && $form->isValid()) {
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($zawodnik);
//                $em->flush();
//
//                return $this->redirectToRoute('zawodnik_new', array('id' => $findById, 'rezultaties'=>$rezultaties));
//            }
        $konkurencjaFullName =  $konkurencjaQuery->getNazwaP();
        return $this->render('zawodnik/indexChoose.html.twig', array(
                    'zawodnik' => $zawodnicy,
                    'form' => $form->createView(),
        ));

        //return $this->render('zawodnik/indexChoose.html.twig', array('zawodnik' => $rezultaties));
    }

// public function indexChooseZAction(Request $request) {
//  $zawodnik = new Zawodnik();
//        $form = $this->createForm('AppBundle\Form\ZawodnikType', $zawodnik);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($zawodnik);
//            $em->flush();
//
//            return $this->redirectToRoute('zawodnik_new', array('id' => $zawodnik->getId()));
//        }
//
//        return $this->render('zawodnik/new.html.twig', array(
//                    'zawodnik' => $zawodnik,
//                    'form' => $form->createView(),
//        ));
//    }
//    public function chooseThisOneZAction(){
//
//        
//        
//   return $this->render('rezultaty/new.html.twig', array(
//                    //'zawodnik' => $rezultaties,
//        ));
//    }

    public function newAction(Request $request) {
        $zawodnik = new Zawodnik();
        $form = $this->createForm('AppBundle\Form\ZawodnikType', $zawodnik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zawodnik);
            $em->flush();

            return $this->redirectToRoute('zawodnik_new', array('id' => $zawodnik->getId()));
        }

        return $this->render('zawodnik/new.html.twig', array(
                    'zawodnik' => $zawodnik,
                    'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, Zawodnik $zawodnik) {
        $deleteForm = $this->createDeleteForm($zawodnik);
        $editForm = $this->createForm('AppBundle\Form\ZawodnikType', $zawodnik);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('zawodnik_edit', array('id' => $zawodnik->getId()));
        }

        return $this->render('zawodnik/edit.html.twig', array(
                    '$zawodnik' => $zawodnik,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }
    public function showAction(Zawodnik $zawodnik)
    {
        $deleteForm = $this->createDeleteForm($zawodnik);

        return $this->render('zawodnik/show.html.twig', array(
            'zawodnik' => $zawodnik,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function deleteAction(Request $request, Zawodnik $zawodnik) {
        $form = $this->createDeleteForm($zawodnik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zawodnik);
            $em->flush();
        }

        return $this->redirectToRoute('zawodnik_index');
    }

    private function createDeleteForm(Zawodnik $zawodnik) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('zawodnik_delete', array('id' => $zawodnik->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function findResultAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();
        if ($request->get('find')) {
            $find = $request->get('find');

            $queryFind = $em->createQuery(''
                    . " SELECT r FROM AppBundle\Entity\Zawodnik r WHERE r.imie LIKE '%"
                    . $find . "%' OR r.nazwisko LIKE '%" . $find . "%' OR r.nrLic LIKE '%"
                    . $find . "%' OR r.klub LIKE '%" . $find . "%' OR r.rokU LIKE '%"
                    . $find . "%'");

            $rez = $queryFind->getResult();

            foreach ($rez as $r) {
                $results['id'] = $r->getId();
                $results['imie'] = $r->getImie();
                $results['nazwisko'] = $r->getNazwisko();
                $results['nrLic'] = $r->getNrLic();
                $results['rokU'] = $r->getRokU();
                $results['klub'] = $r->getKlub();
                $res[] = $results;
            }

            if (isset($res)) {
                $ile = 0;
                foreach ($rez as $r) {

                    $ile += 1;
                }
                return $this->render('zawodnik/indexChoose.html.twig', array(
                            'zawodnik' => $res,
                            'ile' => $ile,
                ));
            } $res = array();

            return $this->render('zawodnik/indexChoose.html.twig', array(
                        'zawodnik' => $res,
            ));
        } else {

            $res = array();

            return $this->render('zawodnik/index.html.twig', array(
                        'zawodnik' => $res,
            ));
        }
    }

    public function findResultChooseAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $konkurencjaId = $session->get('konkurencjaId');
        $konkurencjaQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQuery->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQuery->getNazwaP();
        $konkurencja['id'] = $konkurencjaQuery->getId();
        if ($request->get('find')) {
            $find = $request->get('find');


            $queryFind = $em->createQuery(''
                    . " SELECT r FROM AppBundle\Entity\Zawodnik r WHERE r.imie LIKE '%"
                    . $find . "%' OR r.nazwisko LIKE '%" . $find . "%' OR r.nrLic LIKE '%"
                    . $find . "%' OR r.klub LIKE '%" . $find . "%' OR r.rokU LIKE '%"
                    . $find . "%'");

            $rez = $queryFind->getResult();

            foreach ($rez as $r) {
                $results['id'] = $r->getId();
                $results['imie'] = $r->getImie();
                $results['nazwisko'] = $r->getNazwisko();
                $results['nrLic'] = $r->getNrLic();
                $results['rokU'] = $r->getRokU();
                $results['klub'] = $r->getKlub();
                $res[] = $results;
            }
            if (isset($res)) {

                return $this->render('zawodnik/indexChoose.html.twig', array(
                            'zawodnik' => $res,
                ));
            } $res = array();

            return $this->render('zawodnik/indexChoose.html.twig', array(
                        'zawodnik' => $res,
            ));
        } else {

            $res = array();

            return $this->render('zawodnik/indexChoose.html.twig', array(
                        'zawodnik' => $res,
            ));
        }
    }

}
