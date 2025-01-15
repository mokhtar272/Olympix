<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Compte extends BaseController
{
    public function __construct()
    {


        //...

    }

    public function lister()
    {
        helper('form');
        $this->model = model(Db_model::class);

        $model = model(Db_model::class);
        $data['titre'] = "Liste de tous les comptes";
        $data['logins'] = $model->get_all_compte();
        $data['total_comptes'] = $model->count_all_comptes();

        return view('templates/haut', $data)
            . view('affichage_comptes')
            . view('templates/bas');

    }
    
    
    
    
    
    public function creer()
    {
        helper('form');
        $model = model(Db_model::class);
        $session = session();
    
        if ($session->has('user')) {
            $role = $session->get('role');
            $data['role'] = $role;
            $data['titre'] = 'Ajoute un compte';
    
            if ($this->request->getMethod() == "post") {
                // Règles globales valables pour tous les rôles
                $rules = [
                    'pseudo' => 'required|max_length[255]|min_length[2]',
                    'mdp' => 'required|max_length[255]|min_length[8]',
                    'role' => 'required',
                    'mdp_confirm' => 'required|matches[mdp]', // Nouvelle règle

                ];
    
                // Récupérer le rôle sélectionné
                $roleSelectionne = $this->request->getPost('role');
    
                // Ajouter les règles spécifiques si le rôle est "jury"
                if ($roleSelectionne === 'jury') {
                    $rules['nom'] = 'required';
                    $rules['prenom'] = 'required';
                    $rules['expertise'] = 'required';
                    $rules['biographie'] = 'required';
                }
    
                // Messages d'erreur uniquement pour les champs globaux
                $errors = [
                    'pseudo' => [
                        'required' => 'Veuillez entrer un pseudo pour le compte !',
                        'max_length' => 'Le pseudo ne doit pas dépasser 255 caractères.',
                        'min_length' => 'Le pseudo doit avoir au moins 2 caractères.',
                    ],
                    'mdp' => [
                        'required' => 'Veuillez entrer un mot de passe !',
                        'min_length' => 'Le mot de passe doit contenir au moins 8 caractères.',
                        'max_length' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
                    ],
                    'role' => [
                        'required' => 'Veuillez choisir un rôle (Admin ou Jury).',
                    ],
                    'mdp_confirm' => [
        'required' => 'Veuillez confirmer le mot de passe.',
        'matches' => 'La confirmation du mot de passe ne correspond pas.',
    ],
                ];
    
                if (!$this->validate($rules, $errors)) {
                    // Gestion des erreurs de validation
                    $data['validation'] = $this->validator;
                    return view('templates/haut_admin', $data)
                        . view('menu_administrateur')
                        . view('compte/compte_creer', $data)
                        . view('templates/bas');
                }
                
                if ($model->pseudoExiste($this->request->getPost('pseudo'))) {
                    // Ajouter l'erreur au validateur plutôt que de l'affecter directement à $data
                    $this->validator->setError('pseudo', 'Ce pseudo est déjà pris. Veuillez en choisir un autre.');
                
                    // Renvoi à la vue avec l'erreur ajoutée
                    $data['validation'] = $this->validator;
                    return view('templates/haut_admin', $data)
                        . view('menu_administrateur')
                        . view('compte/compte_creer', $data)
                        . view('templates/bas');
                }
                
                
    
                $recuperation = $this->validator->getValidated();
                $URL = empty($recuperation['URL']) ? NULL : $recuperation['URL'];
    
                if ($roleSelectionne === 'jury') {
                    $model->ajouter_jury(
                        $recuperation['pseudo'],
                        $recuperation['mdp'],
                        $recuperation['nom'],
                        $recuperation['prenom'],
                        $URL,
                        $recuperation['biographie'],
                        $recuperation['expertise']
                    );
                } else if ($roleSelectionne === 'admin') {
                    $model->ajouter_admin($recuperation['pseudo'], $recuperation['mdp']);
                }
    
                return redirect()->to('/compte/afficher_admin');
            }
    
            return view('templates/haut_admin', $data)
                . view('menu_administrateur')
                . view('compte/compte_creer', $data)
                . view('templates/bas');
        } else {
            return redirect()->to('/compte/connecter');
        }
    }
    

    
    public function connecter()
    {
        helper('form');
        $model = model(Db_model::class);
    
        // L’utilisateur a validé le formulaire en cliquant sur le bouton
        if ($this->request->getMethod() == "post") {
            if (
                !$this->validate([
                    'pseudo' => 'required',
                    'mdp' => 'required'
                ])
            ) { 
                // La validation du formulaire a échoué, retour au formulaire !
                return view('templates/haut', ['titre' => 'Se connecter'])
                    . view('menu_visiteur')
                    . view('connexion/compte_connecter')
                    . view('templates/bas');
            }
    
            $username = $this->request->getVar('pseudo');
            $password = $this->request->getVar('mdp');
    
            // Vérifiez si l'utilisateur existe dans la base de données
            $user = $model->connect_compte($username, $password);
            if ($user && is_array($user)) {
                $session = session();
                $id_compte = $user['cmp_idT_COMPTE_cmp']; 
    
                $role = $model->getRoleById($id_compte);
    
                $session->set('user', $username);
                $session->set('role', $role);
                $session->set('id_compte', $id_compte);
    
                $data = [
                    'role' => $role,
                    'username' => $username
                ];
                  
                return redirect()->to('/compte/afficher_profil');

            
                // return view('templates/haut_admin', $data)
                //     . view('menu_administrateur', $data) 
                //     . view('connexion/compte_accueil', $data)
                //     . view('templates/bas_admin', $data);
            } else {
                // Ajoutez un message flash pour indiquer l'échec de la connexion
                session()->setFlashdata('error', 'Pseudo ou mot de passe incorrect.');
    
                // Retour au formulaire de connexion
                return view('templates/haut', ['titre' => 'Se connecter'])
                    . view('menu_visiteur')
                    . view('connexion/compte_connecter')
                    . view('templates/bas');
            }
        }
    
        // L’utilisateur veut afficher le formulaire pour se connecter
        return view('templates/haut', ['titre' => 'Se connecter'])
            . view('menu_visiteur')
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }
    






    public function afficher_profil()
{
    helper('form');
    $model = model(Db_model::class); 
    $session = session();

    if ($session->has('user')) {
        $id_compte = $session->get('id_compte'); 
        $role = $session->get('role'); 

        if ($role === 'Admin') {
            $data['admin'] = $model->getAdminById($id_compte);
            $data['role'] = $role ;
            $data['le_message'] = "Affichage du profil administrateur.";
            return view('templates/haut_admin', $data)
                . view('menu_administrateur', )
                . view('affichage_profil_admin', ) 
                . view('templates/bas_admin', );
        } else
        if ($role === 'Jury') {
            $data['jury'] = $model->getJuryById($id_compte);;
            $data['role']= $role;
            $data['le_message'] = "Affichage du profil du jury.";
            return view('templates/haut_admin', $data)
                . view('menu_administrateur', )
                . view('affichage_profil_jury', ) 
                
                . view('templates/bas_admin', );
        }
    }

    return view('templates/haut', ['titre' => 'Se connecter'])
        . view('menu_visiteur', )
        . view('connexion/compte_connecter')
        . view('templates/bas');
}


    public function deconnecter()
    {

        helper('form');
        $model = model(Db_model::class);
        $session = session();
        $session->destroy();
        return view('templates/haut', ['titre' => 'Se connecter'])
            . view('menu_visiteur')
            . view('connexion/compte_connecter')
            . view('templates/bas');
    }












    public function modifier_profil($id_compte = null)
    {
        helper('form');
        $model = model(Db_model::class);
        $session = session();
    
        if ($id_compte === null) {
            $id_compte = $session->get('id_compte');
        }
    
        $role = $session->get('role');
    
        if (!$session->has('user') || ($id_compte !== $session->get('id_compte') && $role !== 'Admin')) {
            return redirect()->to('/compte/connecter');
        }
    
        $target_role = $model->getRoleById($id_compte);
        if ($target_role === 'Admin') {
            $data['admin'] = $model->getAdminById($id_compte);
        } elseif ($target_role === 'Jury') {
            $data['jury'] = $model->getJuryById($id_compte);
        }
        $data['role'] = $target_role;
    
        if ($this->request->getMethod() === 'post') {
            if ($target_role === 'Admin') {
                $password = $this->request->getPost('password');
                $confirm_password = $this->request->getPost('confirm_password');
    
                if (strlen($password) < 8) {
                    $data['error'] = "Le mot de passe est trop court (minimum 8 caractères).";
                    return view('templates/haut_admin', $data)
                        . view('menu_administrateur', $data)
                        . view('modifie_profil', $data)
                        . view('templates/bas_admin', $data);
                }
    
                if (empty($password) || $password !== $confirm_password) {
                    $data['error'] = "Les mots de passe ne correspondent pas ou sont vides.";
                    return view('templates/haut_admin', $data)
                        . view('menu_administrateur', $data)
                        . view('modifie_profil', $data)
                        . view('templates/bas_admin', $data);
                }
    
                $model->updatePassword($id_compte, $password);
            } elseif ($target_role === 'Jury') {
                $jury_data = [
                    'jry_nom' => $this->request->getPost('nom'),
                    'jry_prenom' => $this->request->getPost('prenom'),
                    'jry_biographie' => $this->request->getPost('biographie'),
                    'jry_discipline_expertise' => $this->request->getPost('discipline'),
                    'jry_url' => $this->request->getPost('url'),
                ];
    
                $password = $this->request->getPost('password');
                $confirm_password = $this->request->getPost('confirm_password');
    
                if (!empty($password)) {
                    if (strlen($password) < 8) {
                        $data['error'] = "Le mot de passe est trop court (minimum 8 caractères).";
                        return view('templates/haut_admin', $data)
                            . view('menu_administrateur', $data)
                            . view('modifie_profil', $data)
                            . view('templates/bas_admin', $data);
                    }
    
                    if ($password !== $confirm_password) {
                        $data['error'] = "Les mots de passe ne correspondent pas.";
                        $data['role'] = $target_role;
    
                        return view('templates/haut_admin', $data)
                            . view('menu_administrateur', $data)
                            . view('modifie_profil', $data)
                            . view('templates/bas_admin', $data);
                    }
    
                    $model->updatePassword($id_compte, $password);
                }
    
                $model->updateJuryProfile($id_compte, $jury_data);
            }
    
            if ($id_compte === $session->get('id_compte')) {
                return redirect()->to('/compte/afficher_profil')->with('success', 'Compte modifié avec succès.');
            } else {
                return redirect()->to('/compte/afficher_admin')->with('success', 'Compte modifié avec succès.');
            }
        }
    
        // Charger la vue de modification
        return view('templates/haut_admin', $data)
            . view('menu_administrateur', $data)
            . view('modifie_profil', $data)
            . view('templates/bas_admin', $data);
    }
    

    








   
        public function gestion_comptes()
        {
            $model = model(Db_model::class);
            $session = session();
            $role = $session->get('role');
            $data['role'] = $role;
            if (!$session->has('user') || $session->get('role') !== 'Admin') {
                return redirect()->to('/compte/connecter');
            }
            
            
            $data['comptes'] = $model->getAllCompte();
            return view('templates/haut_admin')
                . view('menu_administrateur',$data)
                . view('compte/affichage_compte', $data)
                . view('templates/bas_admin');
        }
    
        // public function ajouter_compte()
        // {
        //     helper('form');
        //     $model = model(Db_model::class);
    
        //     if ($this->request->getMethod() === 'post') {
        //         $email = $this->request->getPost('email');
        //         $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        //         $statut = $this->request->getPost('statut');
        //         $nom = $this->request->getPost('nom');
        //         $prenom = $this->request->getPost('prenom');
    
        //         if ($model->compteExiste($email)) {
        //             return redirect()->back()->with('error', 'Ce compte existe déjà.');
        //         }
    
        //         $idCompte = $model->ajouterCompte($email, $password, 'actif');
        //         if ($statut === 'Administrateur') {
        //             $model->ajouterProfilAdmin($idCompte, $nom, $prenom);
        //         } else {
        //             $model->ajouterProfilJury($idCompte, $nom, $prenom, $this->request->getPost('biographie'), $this->request->getPost('discipline'));
        //         }
    
        //         return redirect()->to('/index.php/comptes/gestion_comptes')->with('success', 'Compte ajouté avec succès.');
        //     }
    
        //     return view('templates/haut_admin')
        //         . view('menu_administrateur')
        //         . view('comptes/ajouter')
        //         . view('templates/bas_admin');
        // }






        public function supprimer($id_compte)
{
    $model = model(Db_model::class);

 
    $model->supprimerCompte($id_compte);

    return redirect()->to('/compte/afficher_admin')->with('success', 'Le compte a été supprimé.');
}



public function activer($id_compte)
{
    $model = model(Db_model::class);
    $model->updateCompteEtat($id_compte, '1'); 
    return redirect()->to('/index.php/comptes/gestion_comptes')->with('success', 'Le compte a été activé.');
}

public function desactiver($id_compte)
{
    $model = model(Db_model::class);
    $compte = $model->getCompteById($id_compte);

    if ($compte['e_mail'] === 'organisateur@gmail.com') {
        return redirect()->back()->with('error', 'Ce compte ne peut pas être désactivé.');
    }

    $model->updateCompteEtat($id_compte, '0'); 
    return redirect()->to('/index.php/comptes/gestion_comptes')->with('success', 'Le compte a été désactivé.');
}






public function index()
{
    $model = model(Db_model::class);
    $session = session();
    $role = $session->get('role');


    $stats = [
        'total_concours' => $model->getTotalConcours(),
        'concours_a_venir' => $model->getConcoursByPhase('à venir'),
        'concours_inscription' => $model->getConcoursByPhase('inscription'),
        'concours_preselection' => $model->getConcoursByPhase('PreSelection'),
        'concours_phase_finale' => $model->getConcoursByPhase('Finale'),
        'concours_termines' => $model->getConcoursByPhase('Terminé'),
        'total_candidatures' => $model->getTotalCandidatures(),
        'total_jury' => $model->getTotalJury(),
    ];
     $data['role'] = $role;
    return view('templates/haut_admin')
        . view('menu_administrateur', $data)
        . view('dashbord', ['stats' => $stats])
        . view('templates/bas_admin');
}



    }
    









