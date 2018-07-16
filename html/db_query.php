<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');  //On or Off


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'fallwinter-1819');
    $sql = "select description from courses where COURSE_ID = $id;";
    $results = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($results)) {
        $description = $row['description'];
        ?>

        <div class="resultr card">
            <h1> <?php echo $_POST['course']; ?></h1>
            <h2> <?php echo $_POST['title']; ?></h2>
            <p> <?php echo $description; ?></p>
        </div><?php
    
        }

        $subjectID = "select Subject_ID from courses where COURSE_ID = $id;";
        $sql = "SELECT Subject_ID FROM subject WHERE Subject_ID = \"%$subjectID%\" ";
        $result = mysqli_query($conn, $sql);    

        $sql2 = "select info from courses where Course_ID = $id;";
        $result2 = mysqli_query($conn, $sql2);

        while ($row = mysqli_fetch_assoc($result2)) {
        
        $row0 = mysqli_fetch_assoc($result);
        $subject = $row0['name']; 
        $row2 = mysqli_fetch_assoc($result2);
        $info = $row['info'];
        ?>
        <div class="results card">
            <h1></h1>
            <p> <?php echo $info; ?> </p>
        </div><?php
        }
};
?>