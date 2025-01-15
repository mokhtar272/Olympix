<?php

namespace App\Controllers;
use App\Models\Db_model;

class Concours extends BaseController {

    public function afficher() {
        $model = model(Db_model::class);
        $data['titre'] = "Liste des Concours";
        $data['concours'] = $model->get_all_concours();

        return view('templates/haut', $data)
             .view('menu_visiteur')
             . view('affichage_concours', $data)
             . view('templates/bas');
    }


    public function afficher_jury() {
        $model = model(Db_model::class);
        $session = session();
        $role = $session->get('role');

        if (!$session->has('user') || $role !== 'Jury') {
            return redirect()->to('/compte/connecter');
        }

    
        $id_compte = $session->get('id_compte'); 
        $role = $session->get('role'); 
    
        if ($role === 'Admin') {
            $data['admin'] = $model->getAdminById($id_compte);
        } elseif ($role === 'Jury') {
            $data['jury'] = $model->getJuryById($id_compte);
        }
        $data['role'] = $role;
        $id_compte = $session->get('id_compte');
        $data['titre'] = "Liste des Concours";
        $data['concours'] = $model->get_all_concours_jury($id_compte);

        return view('templates/haut_admin', $data)
                            . view('menu_administrateur', $data)
                            . view('affichage_concours_jury', $data) 
                            . view('templates/bas_admin', $data);
    }





    public function afficher_admin() {
        $model = model(Db_model::class);
        $session = session();
        $role = $session->get('role');

        if (!$session->has('user') || $role !== 'Admin') {
            return redirect()->to('/compte/connecter');
        }

        $id_compte = $session->get('id_compte'); 
        $role = $session->get('role');
        $id_compte= $session->get('id_compte');
        $data['role'] = $role;
        $data['id_compte'] = $id_compte;
        $data['titre'] = "Liste des Concours";
        $data['concours'] = $model->get_all_concours();
    
        return view('templates/haut_admin', $data)
        . view('menu_administrateur', $data)
        . view('affichage_concours_admin', $data) 
        . view('templates/bas_admin', $data);
      }




    public function supprimer($id_concours)
    {
        $model = model(Db_model::class);
        
        $session = session();
        if (!$session->has('user') || ($session->get('role') !== 'Admin')) {
            return redirect()->to('/compte/connecter');
        }
     
        $model->supprimerConcours($id_concours);
    
        return redirect()->to('/concours/afficher_admin')->with('success', 'Le compte a été supprimé.');
    }








    public function creer()
{
    helper('form');
    $model = model(Db_model::class);
    $session = session();


      
    $session = session();
    if (!$session->has('user') || ($session->get('role') !== 'Admin')) {
        return redirect()->to('/compte/connecter');
    }


    if ($session->has('user')) {
        $role = $session->get('role');
        $data['role'] = $role;
        $data['titre'] = 'Ajoute un concours';
         $admin_id = $session->get('id_compte');
        if ($this->request->getMethod() == "post") {
            // Règles de validation pour les champs du concours
            $rules = [
                'titre' => 'required|max_length[100]',
                'description' => 'required|max_length[200]',
                'date_debut' => 'required|valid_date',
                'nb_jours_condidature' => 'required|integer|greater_than[0]',
                'nb_jours_preselection' => 'required|integer|greater_than[0]',
                'nb_jours_selection' => 'required|integer|greater_than[0]',
                'edition' => 'required|max_length[20]',
                'image' => 'permit_empty|valid_url',
            ];

            // Messages d'erreur personnalisés
            $errors = [
                'titre' => [
                    'required' => 'Veuillez entrer le titre du concours.',
                    'max_length' => 'Le titre ne doit pas dépasser 100 caractères.',
                ],
                'description' => [
                    'required' => 'Veuillez fournir une description pour le concours.',
                    'max_length' => 'La description ne doit pas dépasser 200 caractères.',
                ],
                'date_debut' => [
                    'required' => 'Veuillez sélectionner une date de début.',
                    'valid_date' => 'La date de début doit être valide.',
                    'validate_future_date' => 'La date de début doit être supérieure à aujourd\'hui.',

                ],
                'nb_jours_condidature' => [
                    'required' => 'Veuillez indiquer le nombre de jours pour les candidatures.',
                    'integer' => 'Le nombre de jours doit être un entier.',
                    'greater_than' => 'Le nombre de jours doit être supérieur à 0.',
                ],
                // Ajouter des messages similaires pour les autres champs
            ];

            if (!$this->validate($rules, $errors)) {
                // Gestion des erreurs de validation
                $data['validation'] = $this->validator;
                return view('templates/haut_admin', $data)
                    . view('menu_administrateur')
                    . view('concours_creer', $data)
                    . view('templates/bas');
            }

            $dateDebut = $this->request->getPost('date_debut');
            if (!$this->validate_future_date($dateDebut)) {
                $data['validation'] = $this->validator;
                $data['date_error'] = 'La date de début doit être supérieure à aujourd\'hui.';
                return view('templates/haut_admin', $data)
                    . view('menu_administrateur')
                    . view('concours_creer', $data)
                    . view('templates/bas');
            }
            $recuperation = $this->validator->getValidated();
            $model->ajouter_concours(
                $recuperation['titre'],
                $recuperation['description'],
                $recuperation['date_debut'],
                $recuperation['nb_jours_condidature'],
                $recuperation['nb_jours_preselection'],
                $recuperation['nb_jours_selection'],
                $recuperation['edition'],
                $recuperation['image'],
                 $admin_id
            );

            return redirect()->to('/concours/afficher_admin');
        }

        return view('templates/haut_admin', $data)
            . view('menu_administrateur')
            . view('concours_creer', $data)
            . view('templates/bas');
    } else {
        return redirect()->to('/login');
    }
}

public function validate_future_date(string $date): bool
{
    $today = date('Y-m-d');
    return $date > $today;
}





}



    
  