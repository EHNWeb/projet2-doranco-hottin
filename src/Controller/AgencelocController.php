<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\SearchVehiculeType;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgencelocController extends AbstractController
{
    /**
     * @Route("/", name="app_agenceloc")
     */
    public function index(CommandeRepository $repo, Request $superGlobals): Response
    {
        // Création d'un objet commande
        $commande = new Commande();

        // Création du formulaire en suivant la structure de SearchVehiculeType #}
        $form = $this->createForm(SearchVehiculeType::class, $commande);

        // HandleRequest permet d'insérer les données du formulaire dans l'objet $article
        //Elle permet aussi de faire des vérifications sur le formulaire
        $form->handleRequest($superGlobals);

        return $this->render('agenceloc/index.html.twig', [
            'formCommande' => $form->createView(),
        ]);
    }
}
