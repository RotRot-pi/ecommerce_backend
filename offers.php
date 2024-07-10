<?php


include "connect.php" ;



$stmt = $con->prepare("SELECT items1view.* ,CAST((items_price - ((items_price * items_discount) / 100)) AS DOUBLE) AS items_price_after_discount ,
CASE WHEN favorite.favorite_item_id IS NULL THEN 0 ELSE 1 END AS favorite
FROM items1view 
LEFT JOIN categories ON items_category = categories.categories_id
LEFT JOIN favorite ON favorite.favorite_item_id = items_id 
WHERE items_discount != 0;");


$stmt->execute();


$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


$count = $stmt->rowCount();


if ($count > 0) {
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    failureMessage("no data found");
}

?>  