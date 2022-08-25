<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\Commande;
use App\Entity\Vehicule;
use App\Form\MembreType;
use App\Form\CommandeType;
use App\Form\VehiculeType;
use App\Repository\MembreRepository;
use App\Repository\CommandeRepository;
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
    public function admin_vehicules(VehiculeRepository $repo, EntityManagerInterface $manager): Response
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
    public function vehicule_delete(EntityManagerInterface $manager, VehiculeRepository $repo, $id)
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

     /**
     * @Route("/admin/membres", name="admin_membres")
     */
    public function admin_membres(MembreRepository $repo, EntityManagerInterface $manager): Response
    {
        // Récupération des nomd des champs de la table VEHICULE
        $chapmsTableMembre = $manager->getClassMetadata(Membre::class)->getFieldNames();

        // On récupère tous les véhicules
        $membres = $repo->findAll();

        return $this->render('admin/admin_membres.html.twig', [
            'membres' => $membres,
            'colonnes' => $chapmsTableMembre,
        ]);
    }

    /**
     * @Route("/admin/membre/new", name="admin_new_membre")
     * @Route("/admin/membre/edit/{id}", name="admin_edit_membre")
     */
    // La classe REQUEST contient les données véhiculées par les super globales ($_POST, $_GET, ...)
    public function membre_form(Request $superGlobals, EntityManagerInterface $manager, Membre $membre = null)
    {
        // L'objet MEMBRE recevra les données du formulaire
        if (!$membre) {
            $membre = new Membre();
            $membre->setDateEnregistrement(new \DateTime());
            $messageForm = "Le compte utilisateur a bien été crée !";
        } else {
            $messageForm = "Le compte utilisateur n° " . $membre->getId() . " a bien été modifié !";
        }

        // CREATEFORM permet de récupérer un formulaire existant #}
        $form = $this->createForm(MembreType::class, $membre);

        // HandleRequest permet d'insérer les données du formulaire dans l'objet $article
        //Elle permet aussi de faire des vérifications sur le formulaire
        $form->handleRequest($superGlobals);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($membre);
            $manager->flush();
            $this->addFlash('success', $messageForm);
            return $this->redirectToRoute('admin_membres');
        }

        return $this->renderForm("admin/membre_form.html.twig", [
            'formMembre' => $form,
            'editMode' => $membre->getId() !== NULL
        ]);
    }

    /**
     * @Route("/admin/membre/delete/{id}", name="admin_delete_membre")
     */
    public function membre_delete(EntityManagerInterface $manager, MembreRepository $repo, $id)
    {
        $membre = $repo->find($id);

        // remove() prepare la suppression d'un article
        $manager->remove($membre);

        // Execution de la requete preparée
        $manager->flush();

        // addFlash() permet de créer un message de notification
        // Le 1er argument est le type du message que l'on veut
        // Le 2nd argument est le message
        $this->addFlash('success', "Le compte utilisateur n° $id a bien été supprimé !");

        return $this->redirectToRoute("admin_membres");
    }

    /**
     * @Route("/admin/commandes", name="admin_commandes")
     */
    public function admin_commandes(CommandeRepository $repo, EntityManagerInterface $manager): Response
    {
        // Récupération des nomd des champs de la table COMMANDES
        $chapmsTableCommande = $manager->getClassMetadata(Commande::class)->getFieldNames();

        // On récupère toutes les commandes
        $commandes = $repo->findAll();

        return $this->render('admin/admin_commandes.html.twig', [
            'commandes' => $commandes,
            'colonnes' => $chapmsTableCommande,
        ]);
    }

        /**
     * @Route("/admin/commande/new", name="admin_new_commande")
     * @Route("/admin/commande/edit/{id}", name="admin_edit_commande")
     */
    // La classe REQUEST contient les données véhiculées par les super globales ($_POST, $_GET, ...)
    public function commande_form(Request $superGlobals, EntityManagerInterface $manager, Commande $commande = null)
    {
        // L'objet MEMBRE recevra les données du formulaire
        if (!$commande) {
            $commande = new Commande();
            $commande->setDateEnregistrement(new \DateTime());
            $messageForm = "La commande a bien été crée !";
        } else {
            $messageForm = "La commande n° " . $commande->getId() . " a bien été modifiée !";
        }

        // CREATEFORM permet de récupérer un formulaire existant #}
        $form = $this->createForm(CommandeType::class, $commande);

        // HandleRequest permet d'insérer les données du formulaire dans l'objet $article
        //Elle permet aussi de faire des vérifications sur le formulaire
        $form->handleRequest($superGlobals);

        if ($form->isSubmitted() && $form->isValid()) {
            $debutTimeStamp = $commande->getDateHeureDepart()->getTimestamp();
            $finTimeStamp = $commande->getDateHeureFin()->getTimestamp();
            $nbJour = ceil(($finTimeStamp - $debutTimeStamp)/60/60/24);

            $prixTotal = $nbJour * $commande->getIdVehicule()->getPrixJournalier();
            $commande->setPrixTotal(ceil($prixTotal));

            $manager->persist($commande);
            $manager->flush();
            $this->addFlash('success', $messageForm);
            return $this->redirectToRoute('admin_commandes');
        }

        return $this->renderForm("admin/commande_form.html.twig", [
            'formCommande' => $form,
            'editMode' => $commande->getId() !== NULL
        ]);
    }

        /**
     * @Route("/admin/commande/delete/{id}", name="admin_delete_commande")
     */
    public function commande_delete(EntityManagerInterface $manager, CommandeRepository $repo, $id)
    {
        $commande = $repo->find($id);

        // remove() prepare la suppression d'un article
        $manager->remove($commande);

        // Execution de la requete preparée
        $manager->flush();

        // addFlash() permet de créer un message de notification
        // Le 1er argument est le type du message que l'on veut
        // Le 2nd argument est le message
        $this->addFlash('success', "La commande n° $id a bien été supprimée !");

        return $this->redirectToRoute("admin_commandes");
    }
}