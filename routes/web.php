<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
//$agent_function = Session::get('function_key');

Auth::routes();
Route::get('/home', 'Auth/AuthController@home')->name('home');
Route::get('/', 'Auth\AuthController@index')->name('showLog');
Route::get('/connexion', 'Auth\AuthController@showForm')->name('login');
Route::post('/cnx', 'Auth\AuthController@doLogin')->name('doLog');
Route::get('/logout', 'Auth\AuthController@doLogout')->name('Logout');

Route::middleware('auth')->group(function() {
Route::get('/dashboard', 'FrontEnd\HomeController@indexSuper')->name('super.dashboard');
Route::get('/direction', 'DirectionController@indexDirection')->name('super.direction');
Route::get('/service', 'FrontEnd\HomeController@indexService')->name('super.service');
Route::get('/sdirection', 'FrontEnd\HomeController@indexSousdirection')->name('super.sousdirection');

Route::get('/agent', 'FrontEnd\HomeController@indexAgent')->name('super.agent');
Route::get('/nouvel/agent', 'UserController@create_form_agent')->name('nouveau.agent');
Route::post('/agent', 'UserController@store_agent')->name('add.agent');
Route::post('/fonction', 'UserController@store_fonction')->name('add.fonction');
Route::post('/agent/update', 'UserController@update_agent')->name('update.agent');
Route::post('/mdp/update', 'UserController@update_password')->name('update.motdepasse');
Route::get('/agent/profil/{id}', 'UserController@profil')->name('agent.profil');
Route::get('/recherche/agent', 'UserController@searchAgent')->name('search.agent');
Route::get('/organigramme', 'UserController@organigramme')->name('organigramme');
Route::get('/export/agent', 'UserController@exportAgent')->name('export.agent');
Route::get('/export/search/agent', 'UserController@exportSearchAgent')->name('export.searchagent');
Route::get('/nouvelle/fonction/{id}', 'FrontEnd\HomeController@createAgent_form_fonction')->name('nouvelle.fonction');

Route::get('/filiation', 'FrontEnd\HomeController@indexFiliation')->name('filiation.list');
Route::get('/filiation/ajout/{id}', 'FrontEnd\HomeController@create_form_filiation')->name('nouvel.filiation');
Route::post('/filiation/add', 'UserController@storefiliation')->name('add.filiation');
Route::get('/document', 'FrontEnd\HomeController@indexDocument')->name('document.list');
Route::get('/document/ajout/{id}', 'FrontEnd\HomeController@create_form_document')->name('nouveau.document');
Route::post('/document/add', 'UserController@storeDocument')->name('add.document');
Route::post('/profil/photo', 'UserController@updateprofilphoto')->name('update.photo');

Route::get('/demandes', 'FrontEnd\HomeController@indexDemande')->name('super.demande');
Route::get('/planning', 'FrontEnd\HomeController@indexPlanning')->name('conge.planning');
Route::get('/import/planning', 'DemandeController@planning_import')->name('planning.import');
Route::post('/import/planning', 'DemandeController@planningimport_in')->name('planning.import_in');
Route::get('/nouvelle/demande', 'FrontEnd\HomeController@create_form_conge')->name('nouvel.demande');
Route::post('/add/demande', 'DemandeController@store')->name('add.demande');
Route::post('/update/demande', 'DemandeController@updateDemandeConge')->name('update.demande');
Route::post('/update/demande/commentaire', 'DemandeController@updateDemandeCommentaire')->name('update.demande.commentaire');
Route::get('/export/conge', 'DemandeController@exportconge')->name('export.conge');
Route::get('/demandes/detail/{did}', 'DemandeController@showDemandeDetails')->name('demande.detail');
Route::get('/demande/update/state/{did}/{opt}', 'DemandeController@updateDemandeState')->name('edit.demande');

// Route::get('/entree', 'FrontEnd\HomeController@indexEntree')->name('super.entree');
// Route::get('/sortie', 'FrontEnd\HomeController@indexSortie')->name('super.sortie');
// Route::get('/materiel', 'FrontEnd\HomeController@indexMateriel')->name('super.materiel');
// Route::get('/produit', 'FrontEnd\HomeController@indexProduit')->name('super.produit');
// Route::get('/fournisseur', 'FrontEnd\HomeController@indexFournisseur')->name('super.fournisseur');
// Route::get('/fabricant', 'FrontEnd\HomeController@indexFabricant')->name('super.fabricant');
// Route::get('/attribution', 'FrontEnd\HomeController@indexAttribution')->name('super.attribution');

Route::post('/service', 'ServiceController@store')->name('add.service');
Route::post('/materiel', 'MaterielController@storeMateriel')->name('add.materiel');
Route::post('/produit', 'MaterielController@storeProduit')->name('add.produit');
Route::post('/stock', 'StockController@store')->name('add.stock');
Route::post('/fournisseur', 'FournisseurController@store')->name('add.fournisseur');
Route::post('/fabrication', 'FournisseurController@storeFabricant')->name('add.fabricant');

Route::post('/attribution', 'DemandeController@storeAttribution')->name('add.attribution');
Route::get('/intervention/detail/{did}', 'DemandeController@showInterventionDetails')->name('intervention.detail');
Route::post('/rapport', 'DemandeController@storeRapport')->name('add.rapport');

Route::get('/conge/stat', 'StatController@congeStats')->name('stat.conge');
Route::post('/conge/stat', 'StatController@congeStats')->name('get.stat.conge');
Route::get('/intervention/stat', 'StatController@intervention')->name('stat.intervention');

Route::post('/direction', 'DirectionController@store')->name('add.direction');
Route::post('/sousdirection', 'SousdirectionController@store')->name('add.sousdirection');

Route::get('ajax/sousdirection/show/{id}', 'SousdirectionController@showByDirectionID')->name('direction.sousdirection.show');
Route::get('ajax/service/show/{id}', 'SousdirectionController@showBySousDirectionID')->name('sousdirection.service.show');
Route::get('ajax/service_and_responsable/show/{id}/{sid}', 'SousdirectionController@showServiceAndResponsableByDirectionID')->name('sousdirection.serviceandresponsable.show');
Route::get('ajax/agent_responsable/show/{direction}/{sousdirection}/{service}', 'SousdirectionController@showServiceAndResponsableByServiceID')->name('allagent.responsable.show');

Route::get('ajax/all_agent_responsable/show/{direction}/{sousdirection}/{service}', 'SousdirectionController@showAllResponsable')->name('agent.responsable.show');

Route::get('ajax/materiel/show/{id}', 'MaterielController@showMaterielByGroupId')->name('group.materiel.show');
Route::get('ajax/materielDesign/show/{id}', 'MaterielController@getMaterielDesignByMaterielId')->name('group.materiel.show');
Route::get('ajax/interim/show/{id}', 'UserController@showInterimByAgnetId')->name('interim.show');
Route::get('ajax/agent/show/{id}', 'UserController@showAgentByServiceID')->name('service.agent.show');
Route::get('ajax/interimaire/show/{id}', 'UserController@showAgentInterimaire')->name('inteimaire.agent.show');
Route::get('ajax/agent/get/{id}', 'UserController@showAgentByID')->name('get.agent.show');

Route::get('/documentation', 'FrontEnd\HomeController@indexDocumentation')->name('super.documentation');
Route::get('/export/documentation', 'DemandeController@exportdocumentation')->name('export.documentation');
Route::get('/nouvelle/demande/document','DemandeController@nouvelleDemandeDocument')->name('nouvelle.demande.document');
Route::post('/documentation', 'DemandeController@storeDemandeDocument')->name('add.demandeDocument');
Route::get('/doc_demande/detail/{did}', 'DemandeController@showDoc_demandeDetails')->name('doc_demande.detail');
Route::get('/documentation/update/state/{did}/{opt}', 'DemandeController@doc_demande_update')->name('update.document');
Route::post('/document/sent', 'DemandeController@sendDocument')->name('document.send');
Route::get('/documentation/delete/{did}', 'DemandeController@doc_demande_delete')->name('delete.document');
Route::get('/inbox', 'FrontEnd\HomeController@inbox')->name('inbox');
Route::get('/messages/envoyes', 'FrontEnd\HomeController@messagesent')->name('message.sent');
Route::get('/nouveau/message', 'FrontEnd\HomeController@nouveauMessage')->name('nouveau.message');
Route::post('/send/message', 'DemandeController@sendMessage')->name('message.send');
Route::get('/voir/message/{id}', 'FrontEnd\HomeController@viewMessage')->name('view.messages');

Route::get('/communication/liste', 'CommunicationController@viewCommunication')->name('view.communication');
Route::get('/communication/dash', 'CommunicationController@viewComdash')->name('view.comdash');
Route::get('/communication/nouveau', 'CommunicationController@newCommunication')->name('new.communication');
Route::get('/communication/update/state/{did}/{opt}', 'CommunicationController@updateArticleState')->name('edit.articles');
Route::post('/add/article', 'CommunicationController@createCommunication')->name('add.article');
Route::get('/list/article/{id}', 'CommunicationController@showArticleByType')->name('list.article');
Route::get('/detail/article/{id}', 'CommunicationController@showArticleById')->name('detail.article');
Route::get('/edit/article/{aid}', 'CommunicationController@editCommunication')->name('edit.article');
Route::post('/update/article', 'CommunicationController@updateCommunication')->name('update.article');

Route::get('/ptab', 'PtabController@indexptab')->name('ptab');
Route::get('/activiteavalider/{id}/{typ}', 'PtabController@activiteavalider')->name('activite.avalider');
Route::get('/tacheavalider/{id}/{typ}', 'PtabController@tacheavalider')->name('tache.avalider');
Route::post('/ptab/validate', 'PtabController@validatePtab')->name('ptab.validate');
Route::get('/nouveau/ptab', 'PtabController@indexptab')->name('nouveau.ptab');
Route::get('/import/ptab', 'PtabController@importptab')->name('ptab.import');
Route::post('/import/ptab', 'PtabController@ptabimport_in')->name('ptab.import_in');
Route::get('/evalue', 'PtabController@indexevaluation')->name('evalue');

Route::get('/action/supprime/{action}/{type}/{value}', 'PtabController@actionDelete')->name('edit.demande');
Route::post('/add/arret/periode', 'PtabController@actionDesactive')->name('add.arret.periode');
Route::post('/remove/arret/periode', 'PtabController@actionActive')->name('remove.arret.periode');

Route::get('/action/delete/{table}/{champ}/{value}', 'PtabController@deleteState')->name('edit.demande');
Route::get('/ptab/detail/{tid}/{vid}', 'PtabController@showPtabDetails')->name('ptab.detail');
Route::get('/ptab/edit/{tid}/{vid}', 'PtabController@showPtabEditForm')->name('ptab.modif');
Route::get('/ptab/nouveau/{tid}/{id}', 'PtabController@newPtabDetails')->name('ptab.nouveau');
Route::post('/add/ptab', 'PtabController@createptab')->name('add.ptab');
Route::post('/update/ptab', 'PtabController@updateptab')->name('update.ptab');
Route::post('/update/ptab/detail', 'PtabController@updateptabDetail')->name('update.ptab.detail');
Route::post('/update/ptab/trimestre', 'PtabController@updateptabTrimestre')->name('update.ptab.trim');
Route::post('/update/ptab/commentaire', 'PtabController@updateptabCommentaire')->name('update.ptab.commentaire');
Route::post('/livrable/update/state', 'PtabController@updateLivrableState')->name('edit.livrable');
Route::post('/add/ptab/livrable', 'PtabController@addptabLivrable')->name('add.livrable');
Route::post('/send/ptab/livrable', 'PtabController@sendptabLivrable')->name('send.livrable');
Route::get('/delete/livrable/{id}', 'PtabController@deleteLivrable')->name('delete.livrable');
Route::post('/modif/livrable', 'PtabController@modifLivrable')->name('modif.livrable');
Route::get('/ptab/parametre', 'PtabController@parametreptab')->name('reglage.ptab');
Route::get('/bouton/parametre', 'PtabController@parametrebouton')->name('reglage.bouton');
Route::get('/ptab/parametre_form', 'PtabController@parametreptab_form')->name('reglage.form');
Route::post('/add/periode', 'PtabController@createperiode')->name('add.periode');
Route::get('/ptab/parametre/edit/{id}', 'PtabController@parametreptab_updateform')->name('reglage.ptab.edit');
Route::post('/update/periode', 'PtabController@updateperiode')->name('update.periode');
Route::get('/periode/changestate/{periode_id}/{periode_state}', 'PtabController@periode_changestate')->name('periode.changestate');
Route::get('/bouton/changestate/{id}/{state}', 'PtabController@bouton_changestate')->name('bouton.changestate');
Route::get('/ptab/parametre/droit', 'PtabController@parametredroit')->name('reglage.droit');
Route::post('/ptab/parametre/droit', 'PtabController@parametreadddroit')->name('add.droit');
Route::get('/gestion/ptab', 'PtabController@gestionptab')->name('ptab.gestion');
Route::get('ajax/delete_right/{id}', 'PtabController@deleteRigth')->name('delete.agent.rigth');
Route::get('droit/lecture/{id}', 'PtabController@droitdelecture')->name('ptab.read.rigth');

Route::get('/export/ptab/{di?}/{sd?}', 'PtabController@exportPtab')->name('export.ptab');

Route::get('ajax/extrant/show/{id}', 'PtabController@showExtrantByAxe')->name('extrant.show');
Route::get('ajax/action/show/{id}/{dir}/{isagence}', 'PtabController@showActionByExtrant')->name('action.show');
Route::get('ajax/intituleIndicateur/show/{id}', 'PtabController@showintituleIndicateur')->name('indicateurIntitule.show');

Route::get('ajax/activite/show/{id}', 'PtabController@showActiviteByActionType')->name('activite.show');
Route::get('ajax/activiteIntituleIndicateur/show/{id}', 'PtabController@showactiviteIntituleIndicateur')->name('activiteIntituleIndicateur.show');

Route::get('ajax/tache/show/{id}', 'PtabController@showTacheByActiviteType')->name('tache.show');
Route::get('ajax/tacheIntituleIndicateur/show/{id}', 'PtabController@showtacheIntituleIndicateur')->name('tacheIntituleIndicateur.show');
Route::get('ajax/action/archive/{instance}/{type_id}/{state}', 'PtabController@showInstanceAchive')->name('tacheIntituleIndicateur.show');

});
