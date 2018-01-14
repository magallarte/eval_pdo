<?php

require_once( 'fonctions.php' );
include_once( 'header.php' );
include_once( 'ini.php' );

// Requêtes des listes à afficher

$listingnain = makeSelect('SELECT `n_id` AS `IDNAIN`,`n_nom` AS `Nom`FROM `nain` ORDER BY  `n_id` ASC;');
$listingville = makeSelect('SELECT `v_id` AS `IDVILLE`,`v_nom` AS `Ville` FROM `ville` GROUP BY  `v_id` ORDER BY  `v_id` ASC ;');
$listinggroupe = makeSelect('SELECT `g_id` AS `Groupe` FROM `groupe` GROUP BY  `g_id` ORDER BY  `g_id` ASC;');
$listingtaverne = makeSelect('SELECT `t_id` AS `IDTAVERNE`,`t_nom` AS `Taverne` FROM `taverne` GROUP BY  `t_id` ORDER BY  `t_id` ASC;');
?>


<article role="article">
    <header>
        <hgroup>
            <h1 id="h1">BIENVENUE CHEZ LES NAINS !</h1>
            <hr class="hr">
        </hgroup>
    </header>

    <div class="flex-wrapper horizontal justify">
        <div class="x3" style="order:3">

            <!-- Affichage de la liste des nains et formulaire pour choisir un nain -->
            <section>
                <h3 class="legend">Liste des nains</h3>

                <?php
                if( isset( $listingnain ) && count( $listingnain )>0 ) :
                ?>

                    <form action="nain.php" method="get">
                        <table cellpadding="3" style="border-collapse:collapse;" width="30%">
                            <thead>
                                <tr>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">ID </th>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Nom </th>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Choix </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach( $listingnain as $line ) : ?>
                                <tr style="border-bottom:thin solid;">
                                    <td style="border-right:thin solid;"><?php echo $line['IDNAIN']; ?></td>
                                    <td style="border-right:thin solid;"><?php echo $line['Nom']; ?></td>
                                    <td style="border-right:thin solid;"><input type="radio" name="idnain" value="<?php echo $line['IDNAIN']; ?>"><a href=nain.php></a></td>

                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>

                        <br>

                        <p>Cochez le nain pour lequel vous souhaitez obtenir des infos complémentaires et valider. </p>
                         <input type="submit" name="" value="VALIDER">
                    </form>

                <?php
                endif;
                ?>
            </section>

            <!-- Affichage de la liste des villes et formulaire pour choisir une ville -->
            <section>
                <h3 class="legend">Liste des villes</h3>

                <?php
                if( isset( $listingville ) && count( $listingville )>0 ) :
                ?>

                    <form action="ville.php" method="get">
                        <table cellpadding="7" style="border-collapse:collapse;" width="30%">
                            <thead>
                                <tr>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">ID </th>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Ville </th>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Choix </th
                              </tr>
                            </thead>
                            <tbody>

                                <?php foreach( $listingville as $line ) : ?>
                                <tr style="border-bottom:thin solid;">
                                    <td style="border-right:thin solid;"><?php echo $line['IDVILLE']; ?></td>
                                    <td style="border-right:thin solid;"><?php echo $line['Ville']; ?></td>
                                    <td style="border-right:thin solid;"><input type="radio" name="idville" value="<?php echo $line['IDVILLE']; ?>"><a href=ville.php></a></td>

                               </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>

                        <br>

                        <p>Cochez la ville dont vous souhaitez obtenir des infos complémentaires et valider. </p>
                         <input type="submit" name="" value="VALIDER">
                    </form>

                <?php
                endif;
                ?>
            </section>

            <!-- Affichage de la liste des groupes et formulaire pour choisir un groupe -->
            <section>
                <h3 class="legend">Liste des groupes</h3>

                <?php
                if( isset( $listinggroupe ) && count( $listinggroupe )>0 ) :
                ?>

                    <form action="groupe.php" method="get">
                        <table cellpadding="7" style="border-collapse:collapse;" width="30%">
                            <thead>
                                <tr>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Groupe </th>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Choix </th
                               </tr>
                            </thead>
                            <tbody>

                                <?php foreach( $listinggroupe as $line ) : ?>
                                <tr style="border-bottom:thin solid;">
                                    <td style="border-right:thin solid;"><?php echo $line['Groupe']; ?></td>
                                    <td style="border-right:thin solid;"><input type="radio" name="idgroupe" value="<?php echo $line['Groupe']; ?>"><a href=groupe.php></a></td>
                              </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>

                        <br>

                        <p>Cochez le groupe dont vous souhaitez obtenir des infos complémentaires et valider. </p>
                         <input type="submit" name="" value="VALIDER">
                    </form>
                <?php
                endif;
                ?>
            </section>

            <!-- Affichage de la liste des tavernes et formulaire pour choisir une taverne -->
            <section>
                <h3 class="legend">Liste des tavernes</h3>

                <?php
                if( isset( $listingtaverne ) && count( $listingtaverne )>0 ) :
                ?>

                    <form action="taverne.php" method="get">
                        <table cellpadding="7" style="border-collapse:collapse;" width="30%">
                            <thead>
                                <tr>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">ID </th>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Taverne </th>
                                    <th align="left" class="text-cap" style="border-bottom:thin solid;border-right:thin solid;">Choix </th
                                    <td></td>
                             </tr>
                            </thead>
                            <tbody>

                                <?php foreach( $listingtaverne as $line ) : ?>
                                <tr style="border-bottom:thin solid;">
                                    <td style="border-right:thin solid;"><?php echo $line['IDTAVERNE']; ?></td>
                                    <td style="border-right:thin solid;"><?php echo $line['Taverne']; ?></td>
                                    <td style="border-right:thin solid;"><input type="radio" name="idtaverne" value="<?php echo $line['IDTAVERNE']; ?>"><a href=taverne.php></a></td>
                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>

                        <br>

                        <p>Cochez la taverne dont vous souhaitez obtenir des infos complémentaires et valider. </p>
                         <input type="submit" name="" value="VALIDER">
                    </form>
                <?php
                endif;
                ?>
            </section>

        </div>
    </div>
    
<?php
include_once( 'footer.php' );
?>