<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/vehicules", name="admin_vehicules")
     */
    public function adminVehicules(VehiculeRepository $repo, EntityManagerInterface $manager): Response
    {
        // Récupération des nomd des champs de la table VEHICULE
        $chapmsTableVehicule = $manager->getClassMetadata(Vehicule::class)->getFieldNames();

        // On récupère tous les véhicules
        $vehicules = $repo->findAll();

        return $this->render('admin/admin_vehicules.html.twig', [
            'vehicules' => $vehicules,
            'colonnes' => $chapmsTableVehicule,
        ]);
    }

    /**
     * @Route("/admin/vehicule/new", name="admin_new_vehicule")
     * @Route("/admin/vehicule/edit/{id}", name="admin_edit_vehicule")
     */
    // La classe REQUEST contient les données véhiculées par les super globales ($_POST, $_GET, ...)
    public function vehicule_form(Request $superGlobals, EntityManagerInterface $manager, Vehicule $vehicule = null)
    {
        // L'objet VEHICULE recevra les données du formulaire
        if (!$vehicule) {
            $vehicule = new Vehicule();
            $vehicule->setDateEnregistrement(new \DateTime());
            $messageForm = "Le véhicule a bien été crée !";
        } else {
            $messageForm = "Le véhicule n° " . $vehicule->getId() . " a bien été modifié !";
        }

        // CREATEFORM permet de récupérer un formulaire existant #}
        $form = $this->createForm(VehiculeType::class, $vehicule);

        // HandleRequest permet d'insérer les données du formulaire dans l'objet $article
        //Elle permet aussi de faire des vérifications sur le formulaire
        $form->handleRequest($superGlobals);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($vehicule);
            $manager->flush();
            $this->addFlash('success', $messageForm);
            return $this->redirectToRoute('admin_vehicules');
        }

        return $this->renderForm("admin/vehicule_form.html.twig", [
            'formVehicule' => $form,
            'editMode' => $vehicule->getId() !== NULL
        ]);
    }

    /**
     * @Route("/admin/vehicule/delete/{id}", name="admin_delete_vehicule")
     */
    public function article_delete(EntityManagerInterface $manager, VehiculeRepository $repo, $id)
    {
        $vehicule = $repo->find($id);

        // remove() prepare la suppression d'un article
        $manager->remove($vehicule);

        // Execution de la requete preparée
        $manager->flush();

        // addFlash() permet de créer un message de notification
        // Le 1er argument est le type du message que l'on veut
        // Le 2nd argument est le message
        $this->addFlash('success', "Le véhicule n° $id a bien été supprimé !");

        return $this->redirectToRoute("admin_vehicules");
    }

}