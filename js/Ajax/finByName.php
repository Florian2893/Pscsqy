<?php include"../../php/connexion.php"; ?>

<?php
    // récuperer le nom qu'utilisateur saisit 
    $q = $_REQUEST["q"];
    $q = $q.'%';


    $f = 0;
    $a_json = array();
    $a_json_row = array();

    //chercher la moitier de nom dans la table User_Table par matricule   

    $res=$mysqli->query("SELECT   `matricule` ,  `Nom` ,  `Prenom` ,  `Libelle_UG` ,  `Service`.`Libelle_service` ,  `Type_Agent` 
        FROM  `User_Table` ,  `Service` ,  `UG` ,  `Type_Agent` 
        WHERE  `User_Table`.`id_service` =  `Service`.`id_service` 
        AND  `Service`.`Id_UG` =  `UG`.`Id_UG` 
        AND  `User_Table`.`Id_Type_Agent` =  `Type_Agent`.`Id_Type_Agent` 
        AND  `nom` LIKE  '" ."$q". "'" );

    while($row=$res->fetch_array(MYSQLI_ASSOC))
    {
        $a_json_row["id"] = $f;
        //$a_json_row["value"] = $row['Nom'] ;
        $prenom=mb_substr($row["Prenom"],0,1).mb_strtolower(mb_substr($row["Prenom"],1,strlen($row["Prenom"])));
        $a_json_row["value"] = $row['Nom'] ." ".$prenom;
        $label_info = $row['matricule'].','.$row['Nom'].','.$row['Prenom'].','.$row['Libelle_UG'].','.$row['Libelle_service'].','.$row['Type_Agent'].',';
        $a_json_row["desc"] = $label_info;
        array_push($a_json, $a_json_row);
        $f++;
    }

    $json = json_encode($a_json);
    print $json;
    
?>
