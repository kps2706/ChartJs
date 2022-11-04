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
        width: 700px;
    }
    </style>

</head>

<body>

    <div class="container text-center mt-4">
        <div class="row justify-content-center">
            <div class="col-8">
                <!-- <h1>Charts JS!</h1> -->

                <?php

                try {
                    //code...
                    $sql = "SELECT * FROM chartjs.barchart";
                    $result = $pdo->query($sql);

                    if ($result->rowCount() > 0) {
                        # code...
                        $revenue = array();
                        $cost = array();
                        $profit = array();

                        while ($row = $result->fetch()) {
                            # code...
                            // echo "<h4 class='text-muted'>" . $row['revenue'] . "<br>" . "</h4>";
                            $revenue[] = $row["revenue"];
                            $cost[] = $row["cost"];
                            $profit[] = $row["profit"];
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
                <script src="js/chart.js"></script>

                <script>
                // Setup Block
                const revenue = <?php echo json_encode($revenue); ?>;
                const cost = <?php echo json_encode($cost); ?>;
                const profit = <?php echo json_encode($profit); ?>;

                const data = {
                    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange', '7', '8', '9', '10'],
                    datasets: [{

                        label: 'Revenue',
                        data: revenue,
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: ' ',
                        borderRadius: 2,
                        borderWidth: 1
                    }, {
                        label: 'Cost',
                        data: cost,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderRadius: 2,
                        borderWidth: 1
                    }, {
                        label: 'Profit',
                        data: profit,
                        backgroundColor: 'rgba(255, 206, 86, 0.8)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderRadius: 2,
                        borderWidth: 1
                    }]
                };

                // Config Block

                const config = {
                    type: 'bar',
                    data,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Revenue, Profit and Expenses patern over the quaters',
                                font: {
                                    size: 18,
                                }
                            },
                            subtitle: {
                                display: true,
                                text: 'Chart Subtitle',
                                color: 'blue',
                            }
                        },
                        padding: {
                            bottom: 10
                        },
                        responsive: true,
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
                </script>



            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>