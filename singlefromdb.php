<?php

$username = "root";
$password = "";
$database = "chartjs";

try {
    //code...
    $pdo = new PDO("mysql:host=localhost;database=$database", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $th) {
    //throw $th;

    die("ERROR: Could not connect ; " . $th->getMessage());
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TEST FILE</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
    .charts {

        width: auto !important;
        height: 400px !important;
    }
    </style>

</head>

<body>

    <div class="container text-center mt-4">
        <div class="row justify-content-center">
            <div class="col-8">
                <h1>Charts JS!</h1>

                <?php

                try {
                    //code...
                    $sql = "SELECT * FROM chartjs.descriptionlabels
                    INNER JOIN chartjs.datapoints
                    ON descriptionlabels.id = datapoints.descriptionlabelid";

                    $result = $pdo->query($sql);

                    if ($result->rowCount() > 0) {
                        # code...
                        $revenue = array();
                        $labelaxis = array();

                        while ($row = $result->fetch()) {
                            # code...
                            // echo "<h4 class='text-muted'>" . $row['revenue'] . "<br>" . "</h4>";
                            $revenue[] = $row["datapoint"];
                            $labelaxis[] = $row["labelaxis"];


                            $descriptionLabel = ucfirst($row["descriptionlabel"]);
                            $bgcolor = $row["bgcolor"];
                            $bordercolor = $row["bordercolor"];
                        }
                        unset($result);
                    } else {
                        echo "No Record match your query.";
                    }
                } catch (PDOException $e) {
                    //throw $th;
                    die("ERROR: could not able to execute $sql " . $e->getMessage());
                }
                // connection close
                unset($pdo);

                // var_dump($revenue);

                ?>


                <canvas id="myChart" class="charts">

                </canvas>

                <div class="form-group mt-4">
                    <button class="btn btn-outline-primary m-2" onclick="showData(5)">Show 5 Data Points</button>
                    <button class="btn btn-outline-warning m-2" onclick="showData(7)">Show 7 Data Points</button>
                    <button class="btn btn-primary m-2" onclick="resetData()">Show all Data</button>
                </div>


                <script src="js/chart.js"></script>

                <script>
                // Setup Block
                const revenue = <?php echo json_encode($revenue); ?>;
                const labelaxis = <?php echo json_encode($labelaxis); ?>;

                const descriptionLabel = <?php echo json_encode($descriptionLabel); ?>;
                const bgcolor = <?php echo json_encode($bgcolor); ?>;
                const bordercolor = <?php echo json_encode($bordercolor); ?>;

                const data = {
                    labels: labelaxis,
                    datasets: [{
                        label: descriptionLabel,
                        data: revenue,
                        backgroundColor: bgcolor,
                        borderColor: bordercolor,
                        borderWidth: 1
                    }]
                };

                // Config Block

                const config = {
                    type: 'bar',
                    data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                // Render Block
                const myChart = new Chart(
                    document.getElementById("myChart"),
                    config
                );


                function showData(num) {
                    const revenueSliced = revenue.slice(0, num);
                    const labelslced = labelaxis.slice(0, num);

                    // console.log(num);

                    myChart.data.datasets[0].data = revenueSliced;
                    myChart.data.labels = labelslced;

                    myChart.update();
                }

                function resetData() {
                    myChart.data.datasets[0].data = revenue;
                    myChart.data.labels = labelaxis;

                    myChart.update();
                }
                </script>



            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>