<?php

require_once( 'fonctions.php' );
include_once( 'header.php' );
include_once( 'ini.php' );

// S'il n'y a pas de GET, redirection vers l'accueil
if( !isset( $_GET['idville'] ))
{
header( 'Location: .' );
exit;
}
else
{
// Affichage des informations sur la ville sélectionnée

$ligne = makeSelect('SELECT `VILLE`.`v_id` AS `IDVILLE`, `VILLE`.`v_nom` AS `Ville`, `VILLE`.`v_superficie` AS `Superficie`,
          GROUP_CONCAT(DISTINCT`n_nom` SEPARATOR ",") AS `Nains`, GROUP_CONCAT(DISTINCT`n_id` SEPARATOR ",") AS `IDNAIN`,
         GROUP_CONCAT(DISTINCT`t_nom` SEPARATOR ",") AS `Taverne`,GROUP_CONCAT(DISTINCT `taverne`.`t_id` SEPARATOR ",") AS `IDTAVERNE`,
          `t_villearrivee_fk` AS `IDVILLEARRIVEE`, `VILLEARRIVEE`.`v_nom` AS `Ville arrivée`, `t_progres` AS `Progression`
        FROM `ville` AS `VILLE`
        INNER JOIN `nain` ON `VILLE`.`v_id`=`n_ville_fk`
        INNER JOIN `taverne` ON `t_ville_fk`= `VILLE`.`v_id`
        INNER JOIN `tunnel` ON `t_villedepart_fk`= `VILLE`.`v_id`
        INNER JOIN `ville`  AS `VILLEARRIVEE` ON `VILLEARRIVEE`.`v_id`=`t_villearrivee_fk`
        WHERE `VILLE`.`v_id`=:idville',['idville'=>$_GET['idville']])[0];
?>

<article role="article">
    <header>
        <hgroup>
            <h1 id="h1">BIENVENUE CHEZ LES NAINS !</h1>
            <hr class="hr">
        </hgroup>
    </header>

    <div class="flex-wrapper horizontal justify">
        <h3 class="legend">Fiche Ville</h3>

            <aside class="x2" role="complementary" style="order:1">
                <form action="" class="form" method="post">
                    <fieldset class="fieldset">
                        <legend class="legend">Descriptif</legend>

                        <div class="wrapper">
                            <p><span class="titre"> ID :</span>  <?php echo $ligne['IDVILLE']; ?></p>
                            <p><span class="titre"> Ville :</span>  <?php echo $ligne['Ville']; ?></p>
                            <p><span class="titre"> Superficie :</span>  <?php echo $ligne['Superficie']; ?> m2 </p>
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
                            <p><span class="titre"> Taverne(s) présente(s) dans cette ville :</span>
                            <ul>
                                <?php
                                $idtaverne=explode(",", $ligne['IDTAVERNE']);
                                $nomtaverne=explode(",", $ligne['Taverne']);
                                foreach ($idtaverne as $key => $value)
                                {
                                echo '<li><a href= "'. DOMAIN. 'taverne.php?idtaverne='.$value. '" style="color:black">' .$nomtaverne[$key].'</a></p></li>';
                                }
                                ?>
                            </ul>
                            <p><span class="titre"> Tunnel vers la ville de :</span> <a href= "<?php echo DOMAIN. "ville.php?idville=".$ligne['IDVILLEARRIVEE'];?>" style="color:black"><?php echo $ligne['Ville arrivée']; ?></a></p>
                            <p><span class="titre"> Progression du tunnel :</span><?php echo ($ligne['Progression']=='100')? ' ouvert': ''.$ligne['Progression'].'%'; ?> </p>
                        </div>
                    </fieldset>
                </form>
            </aside>
    </div>

<?php
}

include_once( 'footer.php' );
?>