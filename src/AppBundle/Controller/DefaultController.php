<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Session\Session;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {     
         $em = $this->getDoctrine()->getManager();
         $session = new Session();
        $competitionId = $session->get('konkurencjaId');
        $competitionQuery = $em->getRepository('AppBundle:Konkurencja')->findOneByNazwaP($competitionId);
      //  if($$competitionQuery){$competitionFullName =  $competitionQuery->getNazwaP();}
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
           // 'konkurencjaBase'=> $competitionFullName,
            
        ]);
    }
}
