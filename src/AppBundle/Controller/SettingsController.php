<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Settings;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Setting controller.
 *
 */
class SettingsController extends Controller
{
    /**
     * Lists all setting entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $settings = $em->getRepository('AppBundle:Settings')->findAll();

        return $this->render('settings/index.html.twig', array(
            'settings' => $settings,
        ));
    }

    /**
     * Creates a new setting entity.
     *
     */
    public function newAction(Request $request)
    {
        $setting = new Settings();
        $form = $this->createForm('AppBundle\Form\SettingsType', $setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($setting);
            $em->flush();

            return $this->redirectToRoute('settings_show', array('id' => $setting->getId()));
        }

        return $this->render('settings/new.html.twig', array(
            'setting' => $setting,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a setting entity.
     *
     */
    public function showAction(Settings $setting)
    {
        $deleteForm = $this->createDeleteForm($setting);

        return $this->render('settings/show.html.twig', array(
            'setting' => $setting,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing setting entity.
     *
     */
    public function editAction(Request $request, Settings $setting)
    {
        $deleteForm = $this->createDeleteForm($setting);
        $editForm = $this->createForm('AppBundle\Form\SettingsType', $setting);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('settings_edit', array('id' => $setting->getId()));
        }

        return $this->render('settings/edit.html.twig', array(
            'setting' => $setting,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a setting entity.
     *
     */
    public function deleteAction(Request $request, Settings $setting)
    {
        $form = $this->createDeleteForm($setting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($setting);
            $em->flush();
        }

        return $this->redirectToRoute('settings_index');
    }

    /**
     * Creates a form to delete a setting entity.
     *
     * @param Settings $setting The setting entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Settings $setting)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('settings_delete', array('id' => $setting->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
