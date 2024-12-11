<?php
$rows = 6;  //  amount of rows
$cols = 6;  //  amount of columns
$rand_row = rand(1, 6);  // random row
$rand_col = rand(1, 6);  // random column

echo "<table border='1'>";

for($tr=1;$tr<=$rows;$tr++){    
    echo "<tr>";

    for($td=1;$td<=$cols;$td++){
        echo "<td>";

        if($tr == $rand_row && $td == $rand_col) { // check for row and column
            echo "***BOMB***";
        }        
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";

?>