<!-- Debut Page html -->
<html>
<head>
<title>Modifications</title>
</head>

<style>
.mod1{
background:#fff;
margin:auto;
min-width:200px;
max-width:1055px;
text-align:justify;
border: 1px black solid;
/*border-radius: 8px;*/
/*box-shadow: 4px 4px 8px #000;*/
margin-bottom: 15px;
padding: 4px ;
}

.date{
background-color: #ddd;
}

.fichierphp{
color: red;
}

.fichierjava{
color: blue;
}

.fichiercss{
color: green;
}

.fichierautre{
color: pink;
}
</style>

<body>
<div class='mod1'>
<span class='date'>>>> 04/03/2014 <<< </span></br>
Creation Utilisateur UNIX et scripts sur serveur <span class='fichierphp'>[cibleinscription.php] </span></br>
Counter_warning et restriction par utilisateur <span class='fichierautre'>[lshell.conf]</span> </br>
Bouton creation utilisateur <span class='fichierjava'>[Application java]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 05/03/2014 <<< </span></br> 
Voir VMs par utilisateur (cote serveur) <span class='fichierjava'>[Application java]</span> </br>
Fonction d'autocompletion pour JTextfield <span class='fichierjava'>[Application java]</span> </br>
Voir qui utilise les applications <span class='fichierjava'>[Application java]</span> </br>
Fonction pour compter utilisateurs et applications dans BDD (entraine petit changement dans focntions listes) <span class='fichierjava'>[Application java]</span> </br>
Remplacement du lien fermeture dans fenetre popup par croix en haut a droite <span class='fichierphp'>[actualite.php] [pageperso.php] [minichat.php]</span> </br>
Ajout de la classe closepopup pour fenetre popup <span class='fichiercss'>[stylefirefox.css] [stylechrome.css]</span> </br>
Ajout d'une variable de session port ssh et modif port mindterm <span class='fichierphp'>[pageperso.php] [cibleajoutvmnat.php] [cibleajoutvmresint.php] [ciblecreationvm.php] [cibleinscription.php] [ciblelancervm.php] [ciblesupprimervm.php] [pagecible.php]</span> </br>
Ajout variables de session port et serveur sftp <span class='fichierphp'>[pageperso.php] [fichier.php]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 06/03/2014 <<< </span></br>
Voir infos serveur web sur pageperso.php (adresse IP...) <span class='fichierjava'>[Application java]</span> </br>
Rajout infos balise option VMs  <span class='fichierphp'>[pageperso.php] </span></br>
Autocompletion utilisateur <span class='fichierphp'>[minichat.php][options3.php] </span><span class='fichierautre'>[autocomplete3.js] </span></br>
Refonte du systeme de mail. Systeme de conversation a la facebook (pas en js dynamique only php) <span class='fichierphp'>[minichat.php] [minichat_recup2.php]</span> </br>
Ajout au chat de la fonction repondre <span class='fichierphp'>[minichat_recup2.php]</span> </br>
Modification du menu header quand nouveau message <span class='fichierphp'>[minichat_recup2.php] [pageperso.php] [infosperso.php] [actualite.php] [dashboard.php] [minichat.php] [fichiers.php] [telechargements.php]</span> </br>
Fermeture fenetre popup par click sur zone noire <span class='fichierphp'>[minichat.php] [pageperso.php] [actualite.php]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 07/03/2014 <<< </span></br>
Systeme de rating des applications presque complet (nouvelle table dans bdd identique a celle des apps)<span class='fichierphp'> [pageperso.php] [ciblerateapp.php]</span></br>
</div>
<div class='mod1'>
<span class='date'>>>> 10/03/2014 <<< </span></br>
Rajout d'un calendrier pour memo et rajout minute dans table bdd<span class='fichierphp'> [pageperso.php] [ciblememo.php]</span> <span class='fichiercss'>[stylefirefox.css] [stylechrome.css]</span><span class='fichierautre'>[calendar.js] </span></br>
Modifications boutons <span class='fichiercss'>[stylefirefox.css] [stylechrome.css]</span></br>
Description application sur page personelle. Bdd rateAppication modifiee <span class='fichierphp'>[applidescription.php] </span> </br>
Modification du formulaire application <span class='fichierphp'>[pageperso.php] </span> </br>
Rajout de slideshow sur page appli <span class='fichierphp'>[applidescription.php] </span><span class='fichierautre'>[jquery-1.7.2.min.js] [jquery.cycle.lite.js] </span> </br>
<span style='color:#8b008b;'>Mise en place du SSL sur le serveur. https dispnible. [SERVEUR]</span>
</div>
<div class='mod1'>
<span class='date'>>>> 11/03/2014 <<< </span></br>
Page description actu ajoute <span class='fichierphp'>[actudescription.php] </span> </br>
Page store appli et actu creees <span class='fichierphp'>[store.php][store2.php] </span> </br>
Bouton store appli renvoi sur store et champ de recherche dans store (pareil pour actu) <span class='fichierphp'>[pageperso.php][actualite.php] </span> </br>
Raccourci acces store a gauche <span class='fichierphp'>[pageperso.php][actualite.php][store.php][store2.php][actudescription.php][applidescription] </span><span class='fichiercss'>[stylefirefox.css] [stylechrome.css]</span> </br>
Calcul et affichage des notes pour applications <span class='fichierphp'>[applidescription.php] </span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 12/03/2014 <<< </span></br>
Systeme de note application modifiee (5 possibilites au lieu de 3) <span class='fichierphp'>[applidescription.php][pageperso.php] </span> </br>
Protection popup note application (1 vote par user) <span class='fichierphp'> [pageperso.php] </span> </br>
Ajout commentaire utilisateur et redirection vers page appli <span class='fichierphp'> [pageperso.php][cibleavisappli.php][cibleapplidescription.php][applidescription.php][store.php] </span> </br>
Blocage avis si deja ecris <span class='fichierphp'> [applidescription.php]</span> </br>
Quelques modifs de la bdd pour rate (simplification !!) <span class='fichierphp'> [applidescription.php][pageperso.php][ciblerateapp.php]</span> </br>
Application du systeme rate+avis aux actus <span class='fichierphp'> [store2.php][actualite.php][ciblerateactu.php][actudescription.php][cibleavisactu.php][cibleavisdescription]</span> </br>
Refonte fenetre popup VM <span class='fichierphp'> [pageperso.php]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 12/03/2014 <<< </span></br>
Systeme de note application modifiee (5 possibilites au lieu de 3) <span class='fichierphp'>[applidescription.php][pageperso.php] </span> </br>
Si IE renvoie sur page de telechargement browser <span class='fichierphp'> [index.php][notie.php] </span> </br>
<span style='color:#8b008b;'>Cohabitation lshell et Mysecureshell. Espace fichiers dispo sans passer par une VM supplementaire [SERVEUR]</span> <br/>
Dossier VMs pour utilisateur non affiche dans menu <span class='fichierphp'> [fichier.php] </span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 19/03/2014 <<< </span></br>
Modification vitesse download sftp (chargement page plus rapide) <span class='fichierphp'> [fichier.php] </span><span class='fichierautre'> [sftp_config] </span> </br>
Rajout vboxmanage comme commande overssh <span class='fichierautre'> [lshell.conf] </span> </br>
Script php output commande over ssh fonctionnel <span class='fichierphp'> [pagevideo.php] </span> </br>
Verification nom VMs (check serveur/database) <span class='fichierphp'> [pageperso.php] </span> </br>
Remplacement des scripts avec Mindterm par script commande over ssh (sauf pour X11 forwarding)<span class='fichierphp'> [ciblecreationvm.php][ciblesupprimervm.php][cibleajoutvmresint.php][cibleajoutvmnat.php] </span> </br>
Logo et titres modifies <span class='fichierphp'> [ciblecreationvm.php][ciblesupprimervm.php][cibleajoutvmresint.php][cibleajoutvmnat.php] [pageperso.php][fichier.php][index.php][minichat.php][minichat_recup.php][minichat_recup2.php][actualite.php][store.php][store2.php][applidescription.php][actudescription.php][infosperso.php][pagecible.php]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 20/03/2014 <<< </span></br>
Header location mis en place sur systeme VM. Bug de duplication VM corrige. Harmonisation des scripts php<span class='fichierphp'> [ciblecreationvm.php][ciblesupprimervm.php][cibleajoutvmnat.php][cibleajoutvmresint.php] </span> </br>
Systeme de modification de la RAM pour VM<span class='fichierphp'> [pageperso.php][ciblemodifram.php][cibleinscription.php] </span> </br>
Separation processus telechargement fichier de la session<span class='fichierphp'> [fichier.php] </span> </br>
Systeme d'export pour VM<span class='fichierphp'> [pageperso.php][cibleexportvm.php][cibleinscription.php] </span> </br>
Creation script pour liste VMs (vboxmanage non accessible directement)<span class='fichierphp'> [pageperso.php][cibleinscription.php] </span> </br>
Variables de session pour limite rom/ram et espace de stockage<span class='fichierphp'> [pageperso.php]</span> </br>
Harmonisation design presentation vm<span class='fichierphp'> [ciblelancervm.php]</span> </br>
Ecran de chargement pour exportation, creation, suppression, modif ram VM<span class='fichierphp'> [pageperso.php]</span><span class='fichiercss'> [stylefirefox.css][stylechrome.css]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 21/03/2014 <<< </span></br>
Ecran chargement pour flux RSS <span class='fichierphp'> [actualite.php]</span><br/>
Telechargement devient store et modifcation du menu header <span class='fichierphp'> [telechargements.php][actualite.php][pageperso.php][infosperso.php][fichier.php][store.php][store2.php][minichat.php][minichat_recup2.php][dashboard.php][applidescription.php][actudescription.php]</span><br/>
</div>
<div class='mod1'>
<span class='date'>>>> 24/03/2014 <<< </span></br>
Reste ROM et RAM remis en forme <span class='fichierphp'> [pageperso.php]</span><br/>
Systeme d'importation de VMs rapide <span class='fichierphp'> [pagperso.php][cibleimportvm.php][cibleinscription.php]</span><br/>
Style index modifie <span class='fichierphp'> [index.php]</span><br/>
Style conversation modifie <span class='fichierphp'> [minichat_recup2.php]</span><br/>
Correction systeme conversation <span class='fichierphp'> [minichat_recup2.php][minichat_recupbis.php][minichat_recupter.php][minichat.php]</span><br/>
</div>
<div class='mod1'>
<span class='date'>>>> 25/03/2014 <<< </span></br>
Securite anti espace et caracteres speciaux <span class='fichierphp'> [cibleimportvm.php][ciblecreationvm.php]</span><br/>
Modification class button <span class='fichiercss'> [stylefirefox.css][stylechrome.css]</span><br/>
</div>
<div class='mod1'>
<span class='date'>>>> 26/03/2014 <<< </span></br>
Mindterm embarque dans applet (compatibilite safari+chrome) <span class='fichierphp'> [ciblelancervm.php][pagecible.php]</span><br/>
Fonctionnalite ajout images pour application store ajoutee <span class='fichierjava'>[Application java]</span> </br>
Ajout nom appli dans lshell.conf present <span class='fichierjava'>[Application java]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 27/03/2014 <<< </span></br>
Ajout graphiques, statistiques (JFreeChart) <span class='fichierjava'>[Application java]</span> </br>
Fenetrage independant pour application, VMs et Actu <span class='fichierjava'>[Application java]</span> </br>
</div>
<div class='mod1'>
<span class='date'>>>> 04/04/2014 <<< </span></br>
Menu contextuel outils <span class='fichierjava'>[Application java]</span> </br>
Fenetre fichiers important <span class='fichierjava'>[Application java]</span> </br>
Login + variables globales password bdd et root <span class='fichierjava'>[Application java]</span> </br>
Design qui suit l'OS <span class='fichierjava'>[Application java]</span> </br>
Filtre png pour icone appli et actu <span class='fichierjava'>[Application java]</span> </br>
Retrait des liens publicitaires dans flux rss <span class='fichierphp'>[rsslib.php]</span> </br>
</div>
</body>
</html>
