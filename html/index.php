<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
        <title>York University | Course Selection</title>
        <link rel="stylesheet" type="text/css" href="normalize.css" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display|Roboto" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Steacie Hackfest -->
    </head>

    <body>
        <header>
            <script>
                $(document).ready(function ($) {
                    $('#accordioncontainer').find('.accordion').click(function () {
                        this.classList.toggle("activeaccordion");

                        //Expand or collapse this panel
                        $(this).next().slideToggle('fast');
                    });
                });
            </script> 
        </header>

        <div id="sidepanel">

            <img src="Logo_York_University.png" alt="YU">
            <h2>Course Selection</h2>
            <form method ="POST" >
                <input required type="text" name="input" placeholder="Search for a course"/>
                <input type ="submit"/>
            </form>
            <div id="accordioncontainer">
                <h4 class="accordion">Filters</h4>
                <div class="panel">
                    <p>EECS</p>
                    <p>ADMS</p>
                    <p>ACTG</p>
                </div>
            </div>
            <footer>
                <small>
                    <p>Steacie Hackfest 2018 </p>
                </small>
            </footer>
        </div>

        <div id="container">

            <script>
                function get(id1, title1) {
                    $.ajax({
                        type: "POST",
                        url: 'db_query.php',
                        data: ({id: id1, title: title1}),
                        success: function (data) {
                            document.getElementById('content-right').innerHTML = data;
                        }
                    });
                }
            </script>

            <script>
                function getresult(pageNumber, inputGiven) {
                    $.ajax({
                        type: "POST",
                        data: ({page: pageNumber, input: inputGiven}),
                        url: 'limit_query.php',
                        success: function (data) {
                            document.getElementById('content-left').innerHTML = data;
                        }
                    });
                }
            </script>

            <section id="content-left">
                <h2>Your results</h2>
                <?php
                ini_set('error_reporting', E_ALL);
                ini_set('display_errors', 'On');  //On or Off

                include 'db_query.php';

                if (isset($_POST['input'])) {
                    $inp = $_POST['input'];

                    $conn = mysqli_connect('localhost', 'user', 'password', 'courses');

                    $sql = "SELECT * from courses where Course like \"%$inp%\"";
                    $result = mysqli_query($conn, $sql);
                    $number_of_results = mysqli_num_rows($result);
                    $results_per_page = 10;
                    $number_of_pages = ceil($number_of_results / $results_per_page);

                    if (!isset($_POST['page'])) {
                        $page = 1;
                    } else {
                        $page = $_POST['page'];
                    }

                    $first_result = ($page - 1) * $results_per_page;

                    $sql = "select * from courses where Course like \"%$inp%\" LIMIT 0, 10";
                    $results = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($results)) {

                        $term = $row['Term'];
                        $course = $row['Course'];
                        $title = $row['Title'];
                        $subject = $row['Subject'];
                        $id = $row['ID'];
                        ?>

                        <div class="resultl card" onclick="get(<?php echo $id ?>, '<?php echo $course ?>')">
                            <h2><?php echo $course; ?></h2>
                            <p><?php echo $title; ?></p>
                        </div>

                        <?php
                    }
                    ?>
                    <div class="pages"><h4><ul class="pagination">
                                <!--Display links for pages-->
                                <?php for ($page = 1; $page <= $number_of_pages; $page++) { ?>
                                    <li><a onclick="getresult('<?php echo $page ?>', '<?php echo $inp ?>')"> <?php echo $page ?></a></li> <?php
                        }
                        ?>
                        </ul></h4></div>
                        <?php
                }
                ?>


            </section>
            <h2>Preview</h2>
            <section id="content-right">


            </section>


        </div> <!-- div: container -->

    </body>

</html>