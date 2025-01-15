<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class AccueilAdmin extends BaseController
{
 public function afficher()
 {
    return view('templates/haut_admin') . view('affichage_accueil') . view('templates/bas_admin');

 }
}
