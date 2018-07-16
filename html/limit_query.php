<h2>Your results</h2>
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');  //On or Off

if (isset($_POST['input'])) {
    $inp = $_POST['input'];

    if (!isset($_POST['page'])) {
        $page = 1;
    } else {
        $page = $_POST['page'];
    }

    $conn = mysqli_connect('localhost', 'root', '', 'fallwinter-1819');

    $sql = "SELECT * from courses where Name like \"%$inp%\"";
    $result = mysqli_query($conn, $sql);

    $number_of_results = mysqli_num_rows($result);
    $results_per_page = 10;
    $number_of_pages = ceil($number_of_results / $results_per_page);

    $startPage = max(1, $page - $results_per_page/5);
    $endPage = min($number_of_pages, $page + $results_per_page);

    $this_page_first_result = ($page - 1) * $results_per_page;

    $sql = "SELECT * from courses where Name like \"%$inp%\" LIMIT $this_page_first_result, $results_per_page";
    $results = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($results)) {
        $course = $row['Name'];
        $title = $row['Title'];
        $id = $row['Course_ID'];
        ?>
        <div class = "resultl card" onclick="get(<?php echo $id ?>, '<?php echo $title ?>', '<?php echo $course ?>')">
            <h2><?php echo $course; ?></h2>
            <p><?php echo $title; ?></p>
        </div>
        <?php
    }
    ?>
    <div>
        <ul> 
            <!--Display links for pages-->
            <?php for ($i = $startPage; $i <= $endPage; $i++) {
                ?>
                <button class="button" align="center" href="#" onclick="getresult('<?php echo $i ?>', '<?php echo $inp ?>')"> <?php echo $i ?></button> <?php
            }
            ?>
        </ul>
    </div>
    <?php
};
?>
