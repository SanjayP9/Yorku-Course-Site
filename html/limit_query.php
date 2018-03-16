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

    $conn = mysqli_connect('localhost', 'user', 'password', 'courses');

    $sql = "SELECT * from courses where Course like \"%$inp%\"";
    $result = mysqli_query($conn, $sql);

    $number_of_results = mysqli_num_rows($result);
    $results_per_page = 10;
    $number_of_pages = ceil($number_of_results / $results_per_page);

    $this_page_first_result = ($page - 1) * $results_per_page;

    $sql = "select * from courses where Course like \"%$inp%\" LIMIT $this_page_first_result, $results_per_page";
    $results = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($results)) {
        $course = $row['Course'];
        $title = $row['Title'];
        $id = $row['ID'];
        ?>
        <div class = "resultl card" onclick="get(<?php echo $id ?>, '<?php echo $course ?>')">
            <h2><?php echo $course; ?></h2>
            <p><?php echo $title; ?></p>
        </div>
        <?php
    }
?>
    <div class="pages"><h4><ul class = "pagination">
    <!--Display links for pages-->
    <?php for ($page = 1; $page <= $number_of_pages; $page++) {
        ?>
        <li><a onclick="getresult('<?php echo $page ?>', '<?php echo $inp ?>')"> <?php echo $page ?></a></li> <?php
    }
    ?>
    </ul></h4></div>
    <?php
}
?>
