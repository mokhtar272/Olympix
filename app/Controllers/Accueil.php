<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Accueil extends BaseController
{
 public function afficher()
 {
    $model = model(Db_model::class);

    $data['actualites'] = $model->get_all_actualites();


 return view('templates/haut', $data)
 .view('menu_visiteur')
. view('pageAcceuille')
 . view('affichage_accueil',$data)
 . view('templates/bas');
 }
}
?>
