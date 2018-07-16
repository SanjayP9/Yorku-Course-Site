<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
        <title>York University | Course Selection</title>
        <link rel="stylesheet" type="text/css" href="normalize.css" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
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
             <h1>EasyYU</h1>
            <h2>Course Selection</h2>
            <form method ="POST" >
                <input required type="text" name="input" placeholder="Search for a course (ie. EECS 2001, PSYC, BIOL, ...)"/>
                <input type ="submit"/>
            </form>
            <div id="accordioncontainer">
                <h4 class="accordion">Filters</h4>
                <div class="panel">
                <form method="POST">
                    <div class="btn-group-vertical">
                        <button onclick="getfilter('<?php echo 'EECS' ?>')"><?php echo 'EECS' ?></button>
                    </div>
                </form>
                </div>
            </div>
            <footer>
                <small>
                    <p>Last Updated: July 11th, 2018 - 1:30pm </p>
                </small>
            </footer>

            <script>
                function getfilter(subject) {
                    $.ajax({
                        type: "POST",
                        url: 'filterdb.php',
                        data: ({sub: subject}),
                        success: function (data) {
                            document.getElementById('content-right').innerHTML = data;
                        }
                    })
                }
            </script>

        </div>

        <div id="container">

            <script>
                $("limit").css({
                    height: $("resultr card").height()
                });
            </script>

            <script>
                function get(id1, title1, course1) {
                    $.ajax({
                        type: "POST",
                        url: 'db_query.php',
                        data: ({id: id1, title: title1, course: course1}),
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

                    $conn = mysqli_connect('localhost', 'root', '', 'fallwinter-1819');

                    $param = "%{$_POST['input']}%";
                    $stmt = $conn->prepare("SELECT * FROM courses where Name LIKE ?");
                    $stmt->bind_param("s", $param);
                    $stmt->execute();


                    $result = $stmt->get_result();
                    $number_of_results = mysqli_num_rows($result);
                    $results_per_page = 10;
                    $number_of_pages = ceil($number_of_results / $results_per_page);

                   if (!isset($_POST['page'])) {
                       $page = 1;
                   } else {
                       $page = $_POST['page'];
                   }

                   $startPage = max(1, $page - $results_per_page/5);
                   $endPage = min($number_of_pages, $page + $results_per_page);

                   $first_result = ($page - 1) * $results_per_page;

                   $stmt3 = $conn->prepare("SELECT * from courses where Name LIKE ? LIMIT 0, $results_per_page");
                   $stmt3->bind_param("s", $param);
                   $stmt3->execute();

                   $query = "SELECT Subject_ID from courses where Name like \"%$inp%\" ";
                   $sql2 = "SELECT Subject.* FROM subject, courses WHERE (subject.Subject_ID = \"%query%\") ";

                   $results = $stmt3->get_result();
                   $result2 = mysqli_query($conn, $sql2);

                    while ($row = mysqli_fetch_assoc($results)) {
                        $course = $row['Name'];
                        $title = $row['Title'];
                        $id = $row['Course_ID'];
                        ?>

                        <div class="resultl card" onclick="get(<?php echo $id ?>, '<?php echo $title ?>', '<?php echo $course ?>')">
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
                                <button class="button" href="#" onclick="getresult('<?php echo $i ?>', '<?php echo $inp ?>')"> <?php echo $i ?></button> <?php
                            }
                            ?>
                        </ul>
                    </div>
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