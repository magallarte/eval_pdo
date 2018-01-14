<?php

require_once( 'fonctions.php' );
include_once( 'header.php' );
include_once( 'ini.php' );

// Mise à jour de la base de données si une modification d'horaire de début est demandée
if( isset( $_POST['modifhorairesdebut'] ) && isset( $_POST['idgroupemodif'] ))
{
$sql = 'UPDATE `groupe` SET `g_debuttravail`=:modifhorairesdebut WHERE `g_id`=:idgroupe;';
    $params = ['modifhorairesdebut' => $_POST['modifhorairesdebut'], 'idgroupe' => $_POST['idgroupemodif']];
    makeStatement($sql, $params);
}

// Mise à jour de la base de données si une modification d'horaire de fin est demandée
if( isset( $_POST['modifhorairesfin'] ) && isset( $_POST['idgroupemodif'] ))
{
$sql = 'UPDATE `groupe` SET `g_fintravail`=:modifhorairesfin WHERE `g_id`=:idgroupe;';
    $params = ['modifhorairesfin' => $_POST['modifhorairesfin'], 'idgroupe' => $_POST['idgroupemodif']];
    makeStatement($sql, $params);
}

// Mise à jour de la base de données si une modification de tunnel est demandée
if( isset( $_POST['modiftunnel'] ) && isset( $_POST['idgroupemodif'] ))
{
$sql = 'UPDATE `groupe` SET `g_tunnel_fk`=:modiftunnel WHERE `g_id`=:idgroupe;';
    $params = ['modiftunnel' => $_POST['modiftunnel'], 'idgroupe' => $_POST['idgroupemodif']];
    makeStatement($sql, $params);
}

// Mise à jour de la base de données si une modification de taverne est demandée
if( isset( $_POST['modiftaverne'] ) && isset( $_POST['idgroupemodif'] ))
{
$sql = 'UPDATE `groupe` SET `g_taverne_fk`=:modiftaverne WHERE `g_id`=:idgroupe;';
    $params = ['modiftaverne' => $_POST['modiftaverne'], 'idgroupe' => $_POST['idgroupemodif']];
    makeStatement($sql, $params);
}

// Affichage des informations sur le groupe sélectionné
if( !isset( $_GET['idgroupe'] ))
{
    header( 'Location:index.php' );
    exit;
 }
else
{

$ligne = makeSelect('SELECT `g_id` AS `IDGROUPE`, GROUP_CONCAT(DISTINCT`n_nom` SEPARATOR ",") AS `Nains`, GROUP_CONCAT(DISTINCT`n_id` SEPARATOR ",") AS `IDNAIN`,
         `t_nom` AS `Taverne`, `taverne`.`t_id` AS `IDTAVERNE`,
          `t_villedepart_fk` AS `IDVILLEDEPART`, `VILLEDEPART`.`v_nom` AS `Ville départ`,
          `t_villearrivee_fk` AS `IDVILLEARRIVEE`, `VILLEARRIVEE`.`v_nom` AS `Ville arrivée`,
            `g_debuttravail` AS `Début travail`,`g_fintravail` AS `Fin travail`, `t_progres` AS `Progression`, `tunnel`.`t_id` AS `Tunnel`,
            (`t_chambres` - COUNT(`n_id`)) AS `chambresLibres`
           FROM `groupe`
            LEFT JOIN `nain` ON `g_id`=`n_groupe_fk`
             LEFT JOIN `taverne` ON `taverne`.`t_id`=`g_taverne_fk`
              LEFT JOIN `tunnel` ON `g_tunnel_fk`=`tunnel`.`t_id`
              LEFT JOIN `ville`  AS `VILLEARRIVEE` ON `VILLEARRIVEE`.`v_id`=`t_villearrivee_fk`
                LEFT JOIN `ville`  AS `VILLEDEPART` ON `VILLEDEPART`.`v_id`=`t_villedepart_fk`
               WHERE `g_id`=:idgroupe',['idgroupe'=>$_GET['idgroupe']])[0];
    ?>
<article role="article">
    <header>
        <hgroup>
            <h1 id="h1">BIENVENUE CHEZ LES NAINS !</h1>
                <hr class="hr">
        </hgroup>
    </header>

        <div class="flex-wrapper horizontal justify">
            <h3 class="legend">Fiche Groupe</h3>

            <aside class="x2" role="complementary" style="order:1">
                <form action="" class="form" method="post">
                    <fieldset class="fieldset">
                        <legend class="legend">Descriptif</legend>

                            <div class="wrapper">
                                <p><span class="titre"> ID :</span>  <?php echo $ligne['IDGROUPE']; ?><input type="hidden" name="idgroupemodif" value="<?php echo $ligne['IDGROUPE']; ?>"></p>
                                <p><span class="titre"> Nain(s) né(s) dans cette ville :</span>
                                    <ul>
                                        <?php
                                        $idnain=explode(",", $ligne['IDNAIN']);
                                        $nomnain=explode(",", $ligne['Nains']);
                                        foreach ($idnain as $key => $value)
                                        {
                                        echo '<li><a href= "'. DOMAIN. 'nain.php?idnain='.$value. '" style="color:black">' .$nomnain[$key].'</a></p></li>';
                                        }
                                        ?>
                                    </ul>
                                <p><span class="titre"> Taverne :</span> <a href= "<?php echo DOMAIN. "taverne.php?idtaverne=".$ligne['IDTAVERNE'];?>" style="color:black"><?php echo $ligne['Taverne']; ?></a></p>
                                <p><span class="titre"> Horaires de travail :</span>  de <?php echo $ligne['Début travail']; ?> à <?php echo $ligne['Fin travail']; ?> </p>
                                <p><span class="titre"> Tunnel :</span>  n°<?php echo $ligne['Tunnel']; ?> allant de la ville <a href= "<?php echo DOMAIN. "ville.php?idville=".$ligne['IDVILLEDEPART'];?>" style="color:black"><?php echo $ligne['Ville départ']; ?></a> à la ville <a href= "<?php echo DOMAIN. "ville.php?idville=".$ligne['IDVILLEARRIVEE'];?>" style="color:black"><?php echo $ligne['Ville arrivée']; ?></a> </p>
                                <p><span class="titre"> Action dans le tunnel : </span><?php echo ($ligne['Progression']=='100')? ' entretien': 'creusage à '.$ligne['Progression'].'%'; ?> </p>
                            </div>

                            <!--   Formulaire pour changement des horaires -->

                            <div class="wrapper">
                            <h3 class="legend">Modification des horaires</h3>
                                <br>
                                    <label for="liste-groupe">Horaires de début</label>
                                    <select id="liste-groupe" name="modifhorairesdebut">
                                        <?php
                                        $groupe = makeSelect('SELECT `g_debuttravail` FROM `groupe` GROUP BY `g_debuttravail`');
                                            foreach ($groupe as $value)
                                            {
                                            echo '<option selected value="'.$value['g_debuttravail'].'">' .$value['g_debuttravail']. '</option>';
                                            }
                                            ?>
                                    </select>
                                    <label for="liste-groupe">Horaires de fin</label>
                                    <select id="liste-groupe" name="modifhorairesfin">
                                        <?php
                                        $groupe = makeSelect('SELECT `g_fintravail` FROM `groupe` GROUP BY `g_fintravail`');
                                        foreach ($groupe as $value)
                                        {
                                        echo '<option selected value="'.$value['g_fintravail'].'">' .$value['g_fintravail']. '</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                                    
                            <!--   Formulaire pour changement de tunnel -->
                            <div class="wrapper">
                                <h3 class="legend">Modification du tunnel</h3>
                                <br>
                                    <label for="liste-groupe">Tunnel</label>
                                    <select id="liste-groupe" name="modiftunnel">
                                        <?php
                                        $groupe = makeSelect('SELECT `t_id` FROM `tunnel` GROUP BY `t_id`');
                                        foreach ($groupe as $value)
                                        {
                                        echo '<option selected value="'.$value['t_id'].'">' .$value['t_id']. '</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                                    
                            <!--   Formulaire pour changement de taverne -->
                            <div class="wrapper">
                                <h3 class="legend">Modification de la taverne</h3>
                                <br>
                                    <label for="liste-groupe">Taverne</label>
                                    <select id="liste-groupe" name="modiftaverne">
                                            <?php
                                            $groupe = makeSelect('SELECT `t_id`, `t_nom`, (`t_chambres` - COUNT(`n_id`)) AS `chambresLibres`
                                                FROM `taverne`
                                                LEFT JOIN `groupe` ON `g_taverne_fk`=`t_id`
                                                LEFT JOIN `nain` ON `g_id`=`n_groupe_fk`
                                                GROUP BY `t_nom`');
                                            foreach ($groupe as $value)
                                            {
                                            echo ($value['chambresLibres']>'0')? '<option selected value="'.$value['t_id'].'">' .$value['t_nom']. '</option>': '';
                                            }
                                            ?>
                                    </select>
                            </div>
                    </fieldset>

                    <div style="text-align:middle;">
                        <button class="button add dark" type="submit"><span class="inner">Modifier</span></button>
                    </div>
                </form>
            </aside>
        </div>
<?php
}

include_once( 'footer.php' );
?>