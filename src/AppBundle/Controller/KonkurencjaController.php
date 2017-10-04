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

    public function takeOneKonkAction(Request $request) {
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
        $konkurencjaQ = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($konkurencjaId);
        $konkurencja['nazwaS'] = $konkurencjaQ->getNazwaS();
        $konkurencja['nazwaP'] = $konkurencjaQ->getNazwaP();
        $konkurencja['id'] = $konkurencjaQ->getId();


        return $this->render('rezultaty/new.html.twig', array(
                    'konkId' => $konkId,
                    'konkurencja' => $konkurencja,
        ));
    }

    public function findResultAction(Request $request) {

        $session = new Session();
        $em = $this->getDoctrine()->getManager();
     
        if ($request->get('find')) {
            $find = $request->get('find');


            $queryFind = $em->createQuery(''
                    . " SELECT r FROM AppBundle\Entity\Konkurencja r WHERE r.nazwaP LIKE '%" . strtolower($find) . "%' OR r.nazwaS LIKE '%"
                    . strtolower($find) . "%'");

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
