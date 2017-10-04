<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Kluby;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Kluby controller.
 *
 */
class KlubyController extends Controller {

    /**
     * Lists all kluby entities.
     *
     */
    
         public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $kluby = $em->getRepository('AppBundle:Kluby')->findAll();

        return $this->render('kluby/index.html.twig', array(
            'kluby' => $kluby,
        ));
    }
    public function newAction(Request $request) {
        $kluby = new Kluby();
        $form = $this->createForm('AppBundle\Form\KlubyType', $kluby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($kluby);
            $em->flush();

            return $this->redirectToRoute('kluby_show', array('id' => $kluby->getId()));
        }

        return $this->render('kluby/new.html.twig', array(
                    'kluby' => $kluby,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new kluby entity.
     *
     */


    /**
     * Finds and displays a kluby entity.
     *
     */
    public function showAction(Kluby $kluby) {
        $deleteForm = $this->createDeleteForm($kluby);

        return $this->render('kluby/show.html.twig', array(
                    'kluby' => $kluby,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing kluby entity.
     *
     */
    public function editAction(Request $request, Kluby $kluby) {
        $deleteForm = $this->createDeleteForm($kluby);
        $editForm = $this->createForm('AppBundle\Form\KlubyType', $kluby);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kluby_edit', array('id' => $kluby->getId()));
        }

        return $this->render('kluby/edit.html.twig', array(
                    'kluby' => $kluby,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a kluby entity.
     *
     */
    public function deleteAction(Request $request, Kluby $kluby) {
        $form = $this->createDeleteForm($kluby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($kluby);
            $em->flush();
        }

        return $this->redirectToRoute('kluby_index');
    }

    /**
     * Creates a form to delete a kluby entity.
     *
     * @param Kluby $kluby The kluby entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Kluby $kluby) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('kluby_delete', array('id' => $kluby->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }
    
     public function findResultAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        if ($request->get('find')) {
            $find = $request->get('find');


            $queryFind = $em->createQuery(''
                    . " SELECT r FROM AppBundle\Entity\Kluby r WHERE r.nazwaDluga LIKE '%" . $find . "%' OR r.nazwaKrotka LIKE '%"
                    . $find . "%'");

            $rez = $queryFind->getResult();
 $res = array();
            foreach ($rez as $r) {
                $results['id'] = $r->getId();
                $results['nazwaDluga'] = $r->getNazwaDluga();
                $results['nazwaKrotka'] = $r->getNazwaKrotka();
                $res[] = $results;
            }

               
             return $this->render('kluby/index.html.twig', array(
                        'kluby' => $res,
            ));
        }
        
        else{

         $res = array();

            return $this->render('kluby/index.html.twig', array(
                        'kluby' => $res,
            ));
        }
    }

}
