<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');


use App\Controllers\Accueil;
use App\Controllers\AccueilAdmin;



$routes->get('accueil/afficher', [Accueil::class, 'afficher']);
$routes->get('/', 'Accueil::afficher');
$routes->get('accueilAdmin/afficher', [AccueilAdmin::class, 'afficher']);


use App\Controllers\Compte;
$routes->get('compte/lister', [Compte::class, 'lister']);
$routes->get('compte/afficher_admin', [Compte::class, 'gestion_comptes']);
$routes->get('compte/supprimer/(:num)', [Compte::class, 'supprimer/$1']);



use App\Controllers\Actualite;
$routes->get('actualite/afficher', [Actualite::class, 'afficher']);
$routes->get('actualite/afficher/(:num)', [Actualite::class, 'afficher']);

use App\Controllers\Concours;

$routes->get('concours/afficher', [Concours::class, 'afficher']);
$routes->get('concours/afficher_jury', [Concours::class, 'afficher_jury']);
$routes->get('concours/afficher_admin', [Concours::class, 'afficher_admin']);
$routes->get('concours/supprimer/(:num)', [Concours::class, 'supprimer/$1']);





use App\Controllers\Candidature;

$routes->get('candidature/afficher', [Candidature::class, 'afficher']);
$routes->post('candidature/afficher', [Candidature::class, 'afficher']);




$routes->get('compte/creer', [Compte::class, 'creer']);
$routes->post('compte/creer', [Compte::class, 'creer']); 


$routes->get('concours/creer', [Concours::class, 'creer']);
$routes->post('concours/creer', [Concours::class, 'creer']); 

$routes->get('compte/connecter', [Compte::class, 'connecter']);
$routes->post('compte/connecter', [Compte::class, 'connecter']);
$routes->get('compte/dashBord', [Compte::class, 'index']);


$routes->get('Candidature/attribuerNote', [Candidature::class, 'attribuerNote']);
$routes->post('Candidature/attribuerNote', [Candidature::class, 'attribuerNote']);

$routes->get('Candidatures/palmares/(:num)', [Candidature::class, 'afficher_palmares/$1']);


$routes->get('/candidat/inscrire/(:num)', 'Candidature::inscrire/$1'); // Afficher le formulaire d'inscription
$routes->post('/candidat/inscrire/(:num)', 'Candidature::inscrire/$1'); // Traiter le formulaire d'inscription
$routes->get('/candidat/success', 'Candidature::success'); // Afficher la page de succès



// $routes->post('candidature/valider_code', 'Candidature::valider_code');




$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);
$routes->get('compte/afficher_profil', 'Compte::afficher_profil');



$routes->match(['get', 'post'], '/compte/modifier_profil', 'Compte::modifier_profil');
$routes->match(['get', 'post'], 'compte/modifier_profil/(:num)', 'Compte::modifier_profil/$1');


$routes->get('candidatures/liste/(:num)', 'Candidature::afficher_candidatures/$1');




$routes->post('candidature/supprimer', [Candidature::class, 'supprimer']);
