<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            'colonnes' => $chapmsTableVehicule
        ]);
    }
}
