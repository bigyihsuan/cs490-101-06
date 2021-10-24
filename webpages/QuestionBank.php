<?php

include("../account.php");
include("./data_models.php");
global $db;

$query = "SELECT * FROM `Question`;";
($result = $db->query($query)) or die();


?>



<!DOCTYPE html>
<html>
<body>
<table align="center" border ="1px" style="width: 600px; line-height: 40px;">
                        <tr>
                            <th>ID</th>
                            <th>Prompt</th>
                            <th>Difficulty</th>
                            <th>Category</th>
                        </tr>
                        <?
                        
                            while($rows = $result->fetch_all(MYSQLI_ASSOC);)
                            {
                        ?>
                        <tr>
                            <td><?php echo $rows.['id']; ?></td>
                            <td><?php echo $rows.['prompt']; ?></td>
                            <td><?php echo $rows.['difficulty']; ?></td>
                            <td><?php echo $rows.['category']; ?></td>
                            
                        </tr>
                        <?
                            }
                        ?>

                    </table>  

</body>
</html>
