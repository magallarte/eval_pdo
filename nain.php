<?php

require_once( 'fonctions.php' );
include_once( 'header.php' );
include_once( 'ini.php' );

// Mise à jour de la base de données si une modification de group est demandée
if( isset( $_POST['modifgroupe'] ) && isset( $_POST['idnainmodifgroupe'] ))
{

    $sql = 'UPDATE `nain` SET `n_groupe_fk`=:modifgroupe WHERE `n_id`=:idnain;';
    $params = ['modifgroupe' => $_POST['modifgroupe'], 'idnain' => $_POST['idnainmodifgroupe']];
    if($params['modifgroupe'] == 'null')
    {
        $params['modifgroupe'] = null;
    }
    makeStatement($sql, $params);
}

// S'il n'y a pas de GET, redirection vers l'accueil
if(!isset($_GET['idnain']))
{
    header('Location:.');
    exit;
}
else
{

// Affichage des informations sur le nain sélectionné
$ligne = makeSelect('SELECT `n_id` AS `ID`,`n_nom` AS `Nom`, `n_barbe` AS `Barbe`, `VILLENAISSANCE`.`v_id` AS `IDVILLE`, `VILLENAISSANCE`.`v_nom` AS `Ville natale`,
         `n_groupe_fk` AS `IDGROUPE`, `taverne`.`t_id` AS `IDTAVERNE`,`t_nom` AS `Taverne`, `VILLEDEPART`.`v_nom` AS `Ville départ`,
          `VILLEDEPART`.`v_id` AS `IDVILLEDEPART`,`VILLEARRIVEE`.`v_nom` AS `Ville arrivée`, `VILLEARRIVEE`.`v_id` AS `IDVILLEARRIVEE`, `g_debuttravail` AS `Début travail`, `g_fintravail` AS `Fin travail`
        FROM `nain`
        LEFT JOIN `groupe` ON `g_id`=`n_groupe_fk`
        LEFT JOIN `taverne` ON `taverne`.`t_id`=`g_taverne_fk`
        LEFT JOIN `tunnel` ON `g_tunnel_fk`=`tunnel`.`t_id`
        LEFT JOIN `ville` AS `VILLENAISSANCE` ON `VILLENAISSANCE`.`v_id`=`n_ville_fk`
        LEFT JOIN `ville` AS `VILLEDEPART` ON `VILLEDEPART`.`v_id`=`t_villedepart_fk`
        LEFT JOIN `ville` AS `VILLEARRIVEE` ON `VILLEARRIVEE`.`v_id`=`t_villearrivee_fk`
        WHERE `n_id`=:idnain', ['idnain' => $_GET['idnain']])[0];
?>

<article role="article">
    <header>
        <hgroup>
            <h1 id="h1">BIENVENUE CHEZ LES NAINS !</h1>
                <hr class="hr">
        </hgroup>
    </header>

    <div class="flex-wrapper horizontal justify">
        <h3 class="legend">Fiche Nain</h3>

            <aside class="x2" role="complementary" style="order:1">
                <form action="" class="form" method="post">
                    <fieldset class="fieldset">
                        <legend class="legend">Identité</legend>

                            <div class="wrapper">
                                    <p><span class="titre"> ID :</span>  <?php echo $ligne['ID']; ?><input type="hidden" name="idnainmodifgroupe" value="<?php echo $ligne['ID']; ?>"></p>
                                    <p><span class="titre"> Nom :</span>  <?php echo $ligne['Nom']; ?></p>
                                    <p><span class="titre"> Longueur de barbe :</span>  <?php echo $ligne['Barbe']; ?> cm </p>
                                    <p><span class="titre"> Ville de naissance :</span><a href= "<?php echo DOMAIN. "ville.php?idville=".$ligne['IDVILLE'];?>" style="color:black"><?php echo $ligne['Ville natale']; ?></a></p>
                                    <p><span class="titre"> Taverne :</span><a href= "<?php echo DOMAIN. "taverne.php?idtaverne=".$ligne['IDTAVERNE'];?>" style="color:black"><?php echo ($ligne['Taverne']==NULL)? '': ''.$ligne['Taverne'].''; ?></a></p>
                                    <p><span class="titre"> Horaires de travail :</span>  de <?php echo $ligne['Début travail']; ?> à <?php echo $ligne['Fin travail']; ?> </p>
                                    <p><span class="titre"> Tunnel :</span>  allant de <a href= "<?php echo DOMAIN. "ville.php?idville=".$ligne['IDVILLEDEPART'];?>" style="color:black"><?php echo $ligne['Ville départ']; ?></a> à <a href= "<?php echo DOMAIN. "ville.php?idville=".$ligne['IDVILLEARRIVEE'];?>" style="color:black"><?php echo $ligne['Ville arrivée']; ?></a> </p>
                                    <p><span class="titre"> Groupe :</span><?php echo ($ligne['IDGROUPE']==NULL)? 'Aucun groupe': '<a href= "'.DOMAIN. 'groupe.php?idgroupe='.$ligne['IDGROUPE'].'" style="color:black">'.$ligne['IDGROUPE']; ?></a></p>

                            </div>
                              <!--   Formulaire pour changement du groupe -->
                            <div class="wrapper">
                                <h3 class="legend">Modification du groupe</h3>
                                    <br>
                                    <label for="liste-groupe">Groupe</label>
                                        <select id="liste-groupe" name="modifgroupe">
                                        <?php
                                        $groupe = makeSelect('SELECT `n_groupe_fk` FROM `nain` GROUP BY `n_groupe_fk`',[]);

                                                foreach ($groupe as $value)
                                                 {
                                                    echo '<option value="'.$value['n_groupe_fk'].'">' .$value['n_groupe_fk']. '</option>';
                                                }
                                        ?>
                                        </select>
                            </div>
                    </fieldset>

                    <div style="text-align:middle;">
                        <button class="button add dark" type="submit"><span class="inner">Modifier le groupe</span></button>
                    </div>
                </form>
            </aside>
    </div>

<?php
}
include_once( 'footer.php' );
?>