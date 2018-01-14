<?php

require_once( 'fonctions.php' );
include_once( 'header.php' );
include_once( 'ini.php' );

// si pas de GET, redirection vers la page d'accueil
if( !isset( $_GET['idtaverne'] ))
{
    header( 'Location:.' );
    exit;
 }
 else
{
// Affichage des informations sur la taverne sélectionnée

$ligne = makeSelect('SELECT `taverne`.*, (`t_chambres` - COUNT(`n_id`)) AS `chambresLibres`, `VILLETAVERNE`.`v_nom` AS `Ville Taverne`, `VILLETAVERNE`.`v_id` AS `IDVILLETAVERNE`
                FROM `taverne`
                LEFT JOIN `groupe` ON `t_id`=`g_taverne_fk`
                LEFT JOIN `nain` ON `g_id`=`n_groupe_fk`
                LEFT JOIN `ville` AS `VILLETAVERNE` ON `VILLETAVERNE`.`v_id`=`t_ville_fk`
                WHERE `taverne`.`t_id`=:idtaverne
                GROUP BY `t_nom`',['idtaverne' => $_GET['idtaverne']])[0];
?>

<article role="article">
    <header>
        <hgroup>
            <h1 id="h1">BIENVENUE CHEZ LES NAINS !</h1>
                <hr class="hr">
        </hgroup>
    </header>

    <div class="flex-wrapper horizontal justify">
        <h3 class="legend">Fiche Taverne</h3>

            <aside class="x2" role="complementary" style="order:1">
                <form action="" class="form" method="post">
                    <fieldset class="fieldset">
                        <legend class="legend">Descriptif</legend>

                            <div class="wrapper">
                                <p><span class="titre"> ID :</span>  <?php echo $ligne['t_id']; ?></p>
                                <p><span class="titre"> Nom :</span>  <?php echo $ligne['t_nom']; ?></p>
                                <p><span class="titre"> Ville :</span><a href= "<?php echo DOMAIN. "ville.php?idville=".$ligne['IDVILLETAVERNE'];?>" style="color:black"><?php echo $ligne['Ville Taverne']; ?></a></p>
                                <p><span class="titre"> Bière(s) :</span>  <?php echo ($ligne['t_blonde']=='1')? 'blonde, ': ''; ?><?php echo ($ligne['t_brune']=='1')? 'brune, ': ''; ?><?php echo ($ligne['t_rousse']=='1')? 'rousse': ''; ?></p>
                                <p><span class="titre"> Nombre total de chambres :</span>  <?php echo $ligne['t_chambres']; ?></p>
                                <p><span class="titre"> Nombre de chambre(s) libre(s) :</span>  <?php echo $ligne['chambresLibres']; ?></p>

                            </div>
                    </fieldset>
                </form>
            </aside>
    </div>

<?php

}

include_once( 'footer.php' );
?>