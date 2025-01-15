<?php

namespace App\Controllers;
use App\Models\Db_model;

class Candidature extends BaseController {

    public function afficher()
    {
        helper('form');
        $model = model(Db_model::class);
    
        if ($this->request->getMethod() === 'post') {
            // Validation des champs
            $rules = [
                'code_inscription' => 'required',
                'code_candidat'    => 'required',
            ];
    
            if (!$this->validate($rules)) {
                // Si validation échoue, rediriger avec erreurs
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }
    
            // Récupération des données POST
            $code_inscription = $this->request->getPost('code_inscription');
            $code_candidat = $this->request->getPost('code_candidat');
    
            // Vérifier si les codes sont valides
            $candidature = $model->get_candidature_by_codes($code_inscription, $code_candidat);
    
            if (!empty($candidature)) {
                $data['candidature'] = $model->get_candidature_with_documents($code_inscription);
    
                return view('templates/haut', $data)
                    . view('menu_visiteur')
                    . view('affichage_candidature', $data)
                    . view('templates/bas');
            } else {
                // Message flash pour erreur
                session()->setFlashdata('error', 'Code d\'inscription ou code candidat incorrect.');
                return redirect()->to(base_url('/index.php/candidature/afficher'));
            }
        }
    
        // Si méthode GET, afficher le formulaire
        return view('templates/haut', ['titre' => 'Suivi de Candidature'])
            . view('menu_visiteur')
            . view('candidature_formulaire')
            . view('templates/bas');
    }
    
    


    // public function afficher($cand_code) {
    //     $model = model(Db_model::class);
        
    //     $data['candidature'] = $model->get_candidature_with_documents($cand_code);

    //     return view('templates/haut', $data)
    //          .view('menu_visiteur')
    //          . view('affichage_candidature', $data)
    //          . view('templates/bas');
    // }


   
    public function afficher_candidatures($id_concours)
{
    $model = model(Db_model::class); // Charger le modèle


    $session = session();
    $role = $session->get('role');

    if ($session->has('user') && $role === 'Jury') {
        $id_compte = $session->get('id_compte'); 
        $role = $session->get('role');
        $data['candidatures'] = $model->get_candidats_with_documents($id_concours,$id_compte); 
    $data['id_concours'] = $id_concours; 
    $data['titre'] = "Liste des Candidatures"; 
    $data['role']=$role;


    return view('templates/haut_admin', $data)
                . view('menu_administrateur', $data)
                . view('affichage_candidatss', $data) 
                . view('templates/bas_admin', $data);
    }
    elseif($role !== 'Admin'){
        $data['candidatures'] = $model->get_candidats_with_documents($id_concours); 
        $data['id_concours'] = $id_concours; 
        $data['titre'] = "Liste des Candidatures"; 
    
    
        return view('templates/haut', $data)
                    . view('menu_visiteur', $data)
                    . view('affichage_candidats', $data) 
                    . view('templates/bas', $data);

    }else{
        $role = $session->get('role');
        $data['candidatures'] = $model->get_candidats_with_documents($id_concours); 
    $data['id_concours'] = $id_concours; 
    $data['titre'] = "Liste des Candidatures"; 
    $data['role']=$role;


    return view('templates/haut_admin', $data)
                . view('menu_administrateur', $data)
                . view('affichage_candidats', $data) 
                . view('templates/bas_admin', $data);

    }
    

    
}


 

public function supprimer() {
    helper('form');
    $model = model(Db_model::class);

    $code_candidat = $this->request->getPost('code_candidat');
    $code_inscription = $this->request->getPost('code_inscription');

    $model->supprimer_candidature($code_candidat, $code_inscription);

    return redirect()->to(base_url('/'))->with('success', 'Votre candidature a été supprimée avec succès.');
}
public function inscrire($id_conc)
{
    helper(['form', 'url']);
    $model = model(Db_model::class);
    $categories = $model->getCategories($id_conc);

    if ($this->request->getMethod() === 'post') {
        $rules = [
            'nom' => 'required|min_length[3]',
            'prenom' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'confirm_email' => 'required|matches[email]',
            'documents.*' => 'uploaded[documents]|mime_in[documents,application/pdf]|max_size[documents,6000000]',
            'categorie_concours' => 'required|in_list[' . implode(',', array_column($categories, 'ctg_idT_CATEGORIE_ctg')) . ']',
        ];

        if (!$this->validate($rules)) {
            return view('templates/haut', ['titre' => 'Suivi de Candidature'])
                . view('menu_visiteur')
                . view('participer', ['validation' => $this->validator])
                . view('templates/bas');
        }

        $files = $this->request->getFiles();
        $documentPaths = [];
        $uploadPath = FCPATH . 'images';

        if ($files && isset($files['documents'])) {
            foreach ($files['documents'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move($uploadPath, $newName);
                    $documentPaths[] = '/public/images/' . $newName;
                } else {
                    log_message('error', 'Erreur lors du téléchargement du fichier : ' . $file->getErrorString());
                }
            }
        }

        // Génération des codes
        $codeCandidat = substr(md5(uniqid(rand(), true)), 0, 8);
        $codeInscription = substr(md5(uniqid(rand(), true)), 0, 20);

        // Sauvegarde en base
        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'code_candidat' => $codeCandidat,
            'code_inscription' => $codeInscription,
            'documents' => $documentPaths,
            'cnc_id' => $id_conc,
            'ctg_id' => $this->request->getPost('categorie_concours'),
        ];

        if ($model->saveCandidat($data)) {
            // Envoi de l'email avec la fonction mail()
            $to = $data['email'];
            $subject = 'Confirmation de votre candidature';
            $message = "
                Bonjour {$data['prenom']} {$data['nom']},
                
                Votre candidature a été enregistrée avec succès.
                
                Voici vos codes pour le suivi de votre candidature :
                - **Code Candidat** : {$codeCandidat}
                - **Code Inscription** : {$codeInscription}
                
                Utilisez ces codes pour suivre votre candidature sur notre plateforme.
                
                Merci pour votre participation !
            ";

            // En-têtes pour l'email
            $headers = "From: noreply@votre-domaine.com\r\n";
            $headers .= "Reply-To: contact@votre-domaine.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            // Envoi
            if (!mail($to, $subject, $message, $headers)) {
                log_message('error', 'Erreur lors de l\'envoi de l\'e-mail via mail()');
            }

            return redirect()->to('/')->with('success', 'Votre candidature a été soumise avec succès.');
        } else {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement.');
        }
    }

    $data['categories'] = $categories;
    $data['id_conc'] = $id_conc; // Déjà présent ici.
    
    return view('templates/haut', ['titre' => 'Suivi de Candidature'])
        . view('menu_visiteur', $data)
        . view('participer', $data) // Assurez-vous que cette ligne contient bien $data avec 'id_conc'.
        . view('templates/bas');
    
}


public function success()
{      

    return view('success_candidat');
}






public function attribuerNote()
{
    helper('form');
    $model = model(Db_model::class);
    $session = session();

    if ($session->has('user') && $session->get('role') === 'Jury') {
        $cnd_id = $this->request->getPost('cnd_id');
        $cmp_id = $session->get('id_compte'); // L'ID du jury connecté
        $note = $this->request->getPost('note');

        if ($model->attribuerNote($cnd_id, $cmp_id, $note)) {
            $moyenne = $model->calculerMoyenneNoteCandidature($cnd_id);

            // Récupérer la note mise à jour
            $note_actuelle = $model->getNoteCandidat($cnd_id, $cmp_id);

            return redirect()->back()->with('message', 'Note attribuée/modifiée avec succès. Moyenne actuelle : ' . $moyenne)
                ->with('note_actuelle', $note_actuelle);
        } else {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'attribution de la note.');
        }
    }

    return redirect()->to('/')->with('error', 'Accès non autorisé.');
}


 



public function afficher_palmares($id_concours)
{
    $model = model(Db_model::class);

    // Récupérer les trois premiers candidats par catégorie
    $palmares = $model->get_palmares_par_categorie($id_concours);

    // Grouper les résultats par catégorie
    $palmares_par_categorie = [];
    foreach ($palmares as $candidat) {
        $palmares_par_categorie[$candidat['categorie']][] = $candidat;
    }

    $data = [
        'titre' => 'Palmarès',
        'palmares_par_categorie' => $palmares_par_categorie,
    ];

    return view('templates/haut', $data)
        . view('menu_visiteur', $data)
        . view('palmares', $data)
        . view('templates/bas', $data);
}




}
