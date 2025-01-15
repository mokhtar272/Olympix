<?php
namespace App\Models;
use CodeIgniter\Model;
class Db_model extends Model
{
    protected $db;
    public function __construct()
    {
        $this->db = db_connect(); //charger la base de données
        // ou
        // $this->db = \Config\Database::connect();
    }


       // Fonction pour recuperer toutes les comptes

    public function get_all_compte()
    {
        $resultat = $this->db->query("SELECT cmp_e_mail FROM T_COMPTE_cmp;");
        return $resultat->getResultArray();
    }
     





       // Fonction pour recuperer les information d'une actualite


    public function get_actualite($numero)
    {
        $requete = " SELECT * FROM T_ACTUALITE_act WHERE act_idT_ACTUALITE_act = " . $numero . ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }


     // fonction retourne nombre de comptes existe 
    public function count_all_comptes()
    {
        $requete = $this->db->query("SELECT COUNT(*) as total FROM T_COMPTE_cmp;");
        return $requete->getRow()->total;
    }



    // Fonction recuperer toutes les actualites



    public function get_all_actualites()
    {
        $requete = $this->db->query("SELECT * FROM T_ACTUALITE_act
                                     join T_COMPTE_cmp USing(cmp_idT_COMPTE_cmp)
                                     where act_active = 1
                                     order by act_date_pub desc

                                        ;");
        return $requete->getResultArray();
    }


    



     // fonction pour recuperer toutes les concours existe
    public function get_all_concours()
    {
        $requete = "SELECT 
            cnc.cnc_idT_CONCOURS_cnc AS id_concours,
            cnc.cnc_titre AS titre,
            cnc.cnc_date_debut AS date_debut,
            phase_conc(cnc.cnc_idT_CONCOURS_cnc) AS phase_concours,
            donne_categorie(cnc.cnc_idT_CONCOURS_cnc) AS categories,
            donne_jury(cnc.cnc_idT_CONCOURS_cnc) AS jurys,
            donne_date(cnc.cnc_idT_CONCOURS_cnc) AS dates,
            adm.cmp_idT_COMPTE_cmp AS id_administrateur,
            cmp.cmp_e_mail AS email_organisateur,
            cmp.cmp_idT_COMPTE_cmp AS id_compte_organisateur
        FROM 
            T_CONCOURS_cnc AS cnc
        JOIN 
            T_ADMINISTRATEUR_adm AS adm ON cnc.cmp_idT_COMPTE_cmp = adm.cmp_idT_COMPTE_cmp 
        JOIN 
            T_COMPTE_cmp AS cmp ON adm.cmp_idT_COMPTE_cmp = cmp.cmp_idT_COMPTE_cmp
        ORDER BY 
            CASE phase_conc(cnc.cnc_idT_CONCOURS_cnc)
                WHEN 'à venir' THEN 1
                WHEN 'inscription' THEN 2
                WHEN 'PreSelection' THEN 3
                WHEN 'Finale' THEN 4
                WHEN 'Terminé' THEN 5
                ELSE 6
            END;";



        $query = $this->db->query($requete);
        return $query->getResultArray();
    }




     // fonction pour recuperer toutes les concoures pour un jury 

    public function get_all_concours_jury($id)
    {
        $requete = "SELECT 
            cnc.cnc_idT_CONCOURS_cnc AS id_concours,
            cnc.cnc_titre AS titre,
            cnc.cnc_date_debut AS date_debut,
            phase_conc(cnc.cnc_idT_CONCOURS_cnc) AS phase_concours,
            donne_categorie(cnc.cnc_idT_CONCOURS_cnc) AS categories,
            donne_jury(cnc.cnc_idT_CONCOURS_cnc) AS jurys,
            donne_date(cnc.cnc_idT_CONCOURS_cnc) AS dates,
            adm.cmp_idT_COMPTE_cmp AS id_administrateur,
            cmp.cmp_e_mail AS email_organisateur,
            cmp.cmp_idT_COMPTE_cmp AS id_compte_organisateur,
            CandidatsPreselectionnes_concours(cnc.cnc_idT_CONCOURS_cnc) as galerie_accessible

        FROM 
            T_CONCOURS_cnc AS cnc
        JOIN 
            T_ADMINISTRATEUR_adm AS adm ON cnc.cmp_idT_COMPTE_cmp = adm.cmp_idT_COMPTE_cmp 
        JOIN 
            T_COMPTE_cmp AS cmp ON adm.cmp_idT_COMPTE_cmp = cmp.cmp_idT_COMPTE_cmp
        join T_CONCOURS_JURY_tcj AS tcj on tcj.cnc_idT_CONCOURS_cnc = cnc.cnc_idT_CONCOURS_cnc
        where tcj.cmp_idT_COMPTE_cmp = $id
        ORDER BY 
            CASE phase_conc(cnc.cnc_idT_CONCOURS_cnc)
                WHEN 'à venir' THEN 1
                WHEN 'inscription' THEN 2
                WHEN 'PreSelection' THEN 3
                WHEN 'Finale' THEN 4
                WHEN 'Terminé' THEN 5
                ELSE 6
            END;";



        $query = $this->db->query($requete);
        return $query->getResultArray();
    }


        


    // fonction pour recuperer les donnes d'une candidature avec ses documents

    public function get_candidature_with_documents($cand_code)
    {
        $requete = "SELECT 
                cnd.cnd_nom AS nom,
                cnd.cnd_prenom AS prenom,
                cnd.cnd_e_mail AS email,
                cnd.cnd_etat AS etat,
                cnd.cnd_code_inscription AS code_inscription,
                cnd.cnd_code_condidat AS code_candidat,
                dcm.dcm_nom AS doc_nom,
                dcm.dcm_description AS doc_description,
                ctg.ctg_nom AS categorie
            FROM 
                T_CANDIDATURE_cnd AS cnd
            LEFT JOIN 
                T_DOCUMENT_dcm AS dcm 
                ON cnd.cnd_idT_CANDIDATURE_cnd = dcm.cnd_idT_CANDIDATURE_cnd
            JOIN 
                T_CATEGORIE_ctg AS ctg 
                USING(ctg_idT_CATEGORIE_ctg)
            WHERE 
                cnd.cnd_code_inscription = ?;";

        $query = $this->db->query($requete, [$cand_code]);
        return $query->getResultArray();
    }
        

    // fonction pour supprime une candidature

    public function supprimer_candidature($code_candidat, $code_inscription)
    {
        $requete = "CALL supprimer_candidature(?, ?)";
        $this->db->query($requete, [$code_candidat, $code_inscription]);
    }


     // foncton supprimer un compte 
    public function supprimerCompte($id)
    {
        $requete = "CALL supprimer_compte(?)";
        $this->db->query($requete, [$id]);
    }

    
     // fonction supprimer un concours 
    public function supprimerConcours($id)
    {
        $requete = "delete from T_CONCOURS_cnc where cnc_idT_CONCOURS_cnc = ?";
        $this->db->query($requete, [$id]);
    }



    // fonction pour la verification les deux codes de la candidature

    public function get_candidature_by_codes($code_inscription, $code_candidat)
    {
        $requete = "SELECT 
                        cnd.cnd_nom AS nom,
                        cnd.cnd_prenom AS prenom,
                        cnd.cnd_e_mail AS email,
                        cnd.cnd_etat AS etat,
                        donne_documents(cnd.cnd_idT_CANDIDATURE_cnd) AS doc_nom,
                        ctg.ctg_nom AS categorie
                    FROM T_CANDIDATURE_cnd AS cnd
                    LEFT JOIN T_DOCUMENT_dcm AS dcm ON cnd.cnd_idT_CANDIDATURE_cnd = dcm.cnd_idT_CANDIDATURE_cnd
                    JOIN T_CATEGORIE_ctg AS ctg USING(ctg_idT_CATEGORIE_ctg)
                    WHERE cnd.cnd_code_inscription = ? 
                      AND cnd.cnd_code_condidat = ?";

        $query = $this->db->query($requete, [$code_inscription, $code_candidat]);
        return $query->getRowArray(); // Retourne une seule candidature ou NULL
    }



            

    // fonction pour recuperer une candidature avec ses documents
    // public function get_candidats_with_documents($id_conc)
    // {
    //     $requete = "SELECT 
    //             cnd.cnd_idT_CANDIDATURE_cnd As cnd_id,
    //             cnd.cnd_nom AS nom,
    //             cnd.cnd_prenom AS prenom,
    //             cnd.cnd_e_mail AS email,
    //             cnd.cnd_etat AS etat,
    //             donne_documents(cnd.cnd_idT_CANDIDATURE_cnd) AS doc_nom,
    //             ctg.ctg_nom AS categorie
    //         FROM 
    //             T_CANDIDATURE_cnd AS cnd
    //         JOIN 
    //             T_CATEGORIE_ctg AS ctg USING(ctg_idT_CATEGORIE_ctg)
    //         WHERE 
    //             cnd.cnc_idT_CONCOURS_cnc = ?
    //         AND 
    //             cnd.cnd_etat = 'PreSelection'
    //         ORDER BY 
    //             ctg.ctg_nom, cnd.cnd_nom;

    //             ";

    //     $query = $this->db->query($requete, [$id_conc]);
    //     return $query->getResultArray();
    // }


    public function get_candidats_with_documents($id_conc, $id_jury = null)
{
    $requete = "
        SELECT 
            cnd.cnd_idT_CANDIDATURE_cnd AS cnd_id,
            cnd.cnd_nom AS nom,
            cnd.cnd_prenom AS prenom,
            cnd.cnd_e_mail AS email,
            cnd.cnd_etat AS etat,
            donne_documents(cnd.cnd_idT_CANDIDATURE_cnd) AS doc_nom,
            ctg.ctg_nom AS categorie,
            n.nte_note AS note
        FROM 
            T_CANDIDATURE_cnd AS cnd
        JOIN 
            T_CATEGORIE_ctg AS ctg USING(ctg_idT_CATEGORIE_ctg)
        LEFT JOIN 
            T_NOTATION_nte AS n 
            ON cnd.cnd_idT_CANDIDATURE_cnd = n.cnd_idT_CANDIDATURE_cnd 
            AND n.cmp_idT_COMPTE_cmp = ?
        WHERE 
            cnd.cnc_idT_CONCOURS_cnc = ?
        AND 
            cnd.cnd_etat = 'PreSelection'
        ORDER BY 
            ctg.ctg_nom, cnd.cnd_nom;
    ";

    $query = $this->db->query($requete, [$id_jury, $id_conc]);
    return $query->getResultArray();
}



    //

    public function get_nb_comptes()
    {
        $resultat = $this->db->query("SELECT COUNT(*) as nb FROM T_COMPTE_cmp;");
        return $resultat->getRow();
    }


   // Fonction pour ajouter un admin
public function ajouter_admin($login, $mot_de_passe) {
    $sql = "CALL ajoute_admin('$mot_de_passe', '$login')";
    return $this->db->query($sql);
}

// Fonction pour ajouter un jury
public function ajouter_jury($login, $mot_de_passe, $nom, $prenom, $url, $bio, $expertise) {
    $sql = "CALL ajoute_jury('$login', '$mot_de_passe', '$nom', '$prenom', '$url', '$bio', '$expertise')";
    return $this->db->query($sql);
}

    

    //  fonction pour la verification de password et pseudo


    public function connect_compte($username, $password)
    {
        $sql = "SELECT * 
        FROM T_COMPTE_cmp cc 
          WHERE cc.cmp_e_mail = ?
          AND cc.cmp_mote_de_passe = SHA2(CONCAT(?,'salage'), 256)";
        $query = $this->db->query($sql, [$username, $password]);

        return $query->getRowArray(); 
    }

     

    // fonction retourn si l'id passe en parametre appartient à un Jury ou un Admin

    public function getRoleById($id_compte)
    {
        // Appel à la fonction SQL
        $query = $this->db->query("SELECT est_Admin_ou_Jury(?) AS role", [$id_compte]);
        $result = $query->getRowArray();

        return $result ? $result['role'] : null; // Retourne 'Admin', 'Jury', ou null si inexistant
    }

      

    // fonction recuperer les donnes d'un jury
    public function getJuryById($id_compte)
    {
        $sql = "SELECT cmp_idT_COMPTE_cmp, jry_nom, jry_prenom, jry_biographie, jry_discipline_expertise, jry_url, jry_photo
            FROM T_JURY_jry
            WHERE cmp_idT_COMPTE_cmp = ?";
        $query = $this->db->query($sql, [$id_compte]);
        return $query->getRowArray(); // Retourne un tableau contenant les données ou NULL
    }


          // fonction verifie si le pseudo est existe


    public function pseudoExiste($pseudo)
    {
        return $this->db->table('T_COMPTE_cmp')
            ->where('cmp_e_mail', $pseudo)
            ->countAllResults() > 0;
    }

        // fonction recuperer les donnes d'un Admin


    public function getAdminById($id_compte)
    {
        $sql = "SELECT T_ADMINISTRATEUR_adm.cmp_idT_COMPTE_cmp,T_COMPTE_cmp.cmp_mote_de_passe, T_COMPTE_cmp.cmp_e_mail as e_mail
FROM T_ADMINISTRATEUR_adm
JOIN T_COMPTE_cmp USING(cmp_idT_COMPTE_cmp)
where T_ADMINISTRATEUR_adm.cmp_idT_COMPTE_cmp = ? ";
        $query = $this->db->query($sql, [$id_compte]);
        return $query->getRowArray(); // Retourne un tableau contenant les données ou NULL
    }

       


    // fonction pour la modification  mot de passe  d'un compte


    public function updatePassword($id_compte, $password)
    {
        $sql = "UPDATE T_COMPTE_cmp cmp
SET cmp_mote_de_passe = SHA2(CONCAT(?, 'salage'), 256)
WHERE cmp.cmp_idT_COMPTE_cmp = ?";
        $this->db->query($sql, [$password, $id_compte]);
    }


    

    //  fonction modifie les donnes d'un jury
    public function updateJuryProfile($id_compte, $data)
    {
        $sql = "UPDATE T_JURY_jry
            SET jry_nom = ?, 
                jry_prenom = ?, 
                jry_biographie = ?, 
                jry_discipline_expertise = ?, 
                jry_url = ?
            WHERE cmp_idT_COMPTE_cmp = ?";
        $this->db->query($sql, [
            $data['jry_nom'],
            $data['jry_prenom'],
            $data['jry_biographie'],
            $data['jry_discipline_expertise'],
            $data['jry_url'],
            $id_compte
        ]);
    }



   // fonction recuperer toutes les comptes existe via une vue
 
public function getAllCompte()
{
    $query = $this->db->query("SELECT * FROM vue_comptes_roles");
    return $query->getResultArray();
}


   

   // fonction ajouter un concours
     

    public function ajouter_concours(
        $titre,
        $description,
        $date_debut,
        $nb_jours_condidature,
        $nb_jours_preselection,
        $nb_jours_selection,
        $edition,
        $image,
        $admin_id
    ) {
        $this->db->query("
    INSERT INTO T_CONCOURS_cnc (
        cnc_titre,
        cnc_description,
        cnc_date_debut,
        cnc_nbJours_condidature,
        cnc_nbJours_preSelection,
        cnc_nbJours_Selection,
        cnc_edition,
        cnc_image,
        cmp_idT_COMPTE_cmp
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
        $titre,
        $description,
        $date_debut,
        $nb_jours_condidature,
        $nb_jours_preselection,
        $nb_jours_selection,
        $edition,
        $image,
        $admin_id
    ]
);

    }
    

















    protected $table = 'T_NOTATION_nte';
    protected $primaryKey = 'id';  // Exemple de clé primaire
    protected $allowedFields = ['cnd_idT_CANDIDATURE_cnd', 'cmp_idT_COMPTE_cmp', 'nte_note'];
    
    public function attribuerNote($cnd_id, $cmp_id, $note)
    {
        // Vérifier si une note existe déjà
        $exist = $this->db->table('T_NOTATION_nte')
            ->where('cnd_idT_CANDIDATURE_cnd', $cnd_id)
            ->where('cmp_idT_COMPTE_cmp', $cmp_id)
            ->get()
            ->getRowArray();

        if ($exist) {
            // Mettre à jour la note
            return $this->db->table('T_NOTATION_nte')
                ->where('cnd_idT_CANDIDATURE_cnd', $cnd_id)
                ->where('cmp_idT_COMPTE_cmp', $cmp_id)
                ->update(['nte_note' => $note]);
        } else {
            // Insérer une nouvelle note
            return $this->db->table('T_NOTATION_nte')
                ->insert([
                    'cnd_idT_CANDIDATURE_cnd' => $cnd_id,
                    'cmp_idT_COMPTE_cmp' => $cmp_id,
                    'nte_note' => $note
                ]);
        }
    }

    public function getNoteCandidat($cnd_id, $cmp_id)
    {
        return $this->db->table('T_NOTATION_nte')
            ->select('nte_note')
            ->where(['cnd_idT_CANDIDATURE_cnd' => $cnd_id, 'cmp_idT_COMPTE_cmp' => $cmp_id])
            ->get()
            ->getRowArray()['nte_note'] ?? null;
    }
    
    public function calculerMoyenneNoteCandidature($cnd_id)
    {
        $result = $this->db->table('T_NOTATION_nte')
            ->select('AVG(nte_note) as moyenne')
            ->where('cnd_idT_CANDIDATURE_cnd', $cnd_id)
            ->get()
            ->getRowArray();

        return $result['moyenne'] ?? 0;
    }



  
    // protected $table = 'T_CANDIDATURE_cnd';
    // protected $primaryKey = 'cnd_idT_CANDIDATURE_cnd';
    // protected $allowedFields = [
    //     'cnd_nom', 'cnd_prenom', 'cnd_e_mail', 'cnd_code_condidat', 'cnd_code_inscription',
    //     'ctg_idT_CATEGORIE_ctg', 'cnc_idT_CONCOURS_cnc', 'cnd_etat', 'cnd_annulation'
    // ];





    

    public function saveCandidat($data)
{
    $this->db->transStart();

    // Insertion dans T_CANDIDATURE
    $insertData = [
        'cnd_nom' => $data['nom'],
        'cnd_prenom' => $data['prenom'],
        'cnd_e_mail' => $data['email'],
        'cnd_code_condidat' => $data['code_candidat'],
        'cnd_code_inscription' => $data['code_inscription'],
        'ctg_idT_CATEGORIE_ctg' => $data['ctg_id'],
        'cnc_idT_CONCOURS_cnc' => $data['cnc_id'],
        'cnd_etat' => 'En attente',
        'cnd_annulation' => 0,
    ];

    $this->insert($insertData);

    if (!$this->db->affectedRows()) {
        log_message('error', 'Erreur lors de l\'insertion dans T_CANDIDATURE : ' . json_encode($this->db->error()));
        return false;
    }

    // Récupération de l'ID inséré
    $candidatureId = $this->insertID();
    if (!$candidatureId) {
        log_message('error', 'Aucun ID de candidature inséré : ' . json_encode($this->db->error()));
        return false;
    }

    // Insertion des documents dans T_DOCUMENT
    $documentsTable = $this->db->table('T_DOCUMENT_dcm');
    foreach ($data['documents'] as $path) {
        $documentData = [
            'dcm_nom' => basename($path),
            'dcm_description' => null,
            'cnd_idT_CANDIDATURE_cnd' => $candidatureId,
        ];

        $documentsTable->insert($documentData);

        if (!$this->db->affectedRows()) {
            log_message('error', 'Erreur lors de l\'insertion dans T_DOCUMENT : ' . json_encode($documentData) . ' - ' . json_encode($this->db->error()));
            return false;
        }
    }

    $this->db->transComplete();

    if (!$this->db->transStatus()) {
        log_message('error', 'Transaction échouée : ' . json_encode($this->db->error()));
        return false;
    }

    return true;
}

    public function getCategories($id_concours)
    {
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT cc.ctg_idT_CATEGORIE_ctg, ctg_nom
            FROM T_CATEGORIE_CONCOURS_tcc AS cc
            JOIN T_CATEGORIE_ctg AS c ON cc.ctg_idT_CATEGORIE_ctg = c.ctg_idT_CATEGORIE_ctg
            WHERE cc.cnc_idT_CONCOURS_cnc = ?", [$id_concours]);

        return $query->getResultArray(); // Récupère les catégories sous forme de tableau associatif
    }



















    public function getTotalConcours()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM T_CONCOURS_cnc");
        return $query->getRow()->total;
    }

    public function getConcoursByPhase($phase)
    {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM T_CONCOURS_cnc 
            WHERE phase_conc(cnc_idT_CONCOURS_cnc) = ?", 
            [$phase]
        );
        return $query->getRow()->total;
    }

    public function getTotalCandidatures()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM T_CANDIDATURE_cnd");
        return $query->getRow()->total;
    }

    public function getTotalJury()
    {
        $query = $this->db->query("
            SELECT COUNT(*) AS total 
            FROM T_JURY_jry 
        ");
        return $query->getRow()->total;
    }


    public function get_palmares_par_categorie($id_concours)
    {
        $sql = "
            SELECT 
                cnd.cnd_nom AS nom,
                cnd.cnd_prenom AS prenom,
                cnd.cnd_e_mail AS email,
                cnd.cnd_note_Finale AS note,
                ctg.ctg_nom AS categorie
            FROM 
                T_CANDIDATURE_cnd AS cnd
            JOIN 
                T_CATEGORIE_ctg AS ctg ON cnd.ctg_idT_CATEGORIE_ctg = ctg.ctg_idT_CATEGORIE_ctg
            WHERE 
                cnd.cnc_idT_CONCOURS_cnc = ?
                AND cnd.cnd_note_Finale IS NOT NULL
            ORDER BY 
                ctg.ctg_nom, cnd.cnd_note_Finale DESC
        ";
    
        $query = $this->db->query($sql, [$id_concours]);
    
        // Regrouper les trois premiers candidats par catégorie
        $results = $query->getResultArray();
        $grouped_results = [];
        foreach ($results as $row) {
            $grouped_results[$row['categorie']][] = $row;
            if (count($grouped_results[$row['categorie']]) === 3) {
                $grouped_results[$row['categorie']] = array_slice($grouped_results[$row['categorie']], 0, 3);
            }
        }
    
        return array_merge(...array_values($grouped_results));
    }
    
    

}