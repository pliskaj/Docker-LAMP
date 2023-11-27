<!DOCTYPE html>
<?php
include 'database.php';
$force_load = filemtime("js/behavior.js");
$main_groups = mysqli_query($connect, "SELECT id, title FROM groups WHERE level=0");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
        <link href="/fontawesome/css/all.min.css" rel="stylesheet">
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <title>Výběr HW</title>
    </head>
    <style>
        table td:nth-child(1), table td:nth-child(3), table td:nth-child(4), table td:nth-child(5) {
            width: 100px;
        }

        table td:nth-child(3)::after, table td:nth-child(5)::after {
            content: "\00a0Kč";
        }

        table td:nth-child(3), table td:nth-child(4), table td:nth-child(5) {
            line-height: 36px;
        }

        td.line, td.price {
            text-align: right;
        }

        .table-striped>tbody>tr.green>* {
            background-color: rgba(0,255,0,.2);
        }

        .table-striped>tbody>tr.green:nth-of-type(odd)>* {
            background-color: rgba(50,255,50,.2);
        }

        .fixed-head {
            background-color: #f7f7f7;
            border-bottom: 1px solid #dfdfdf;
            height: 40px;
            width: 100%;
            position: fixed;
            z-index: 1;
            top: 0;
        }

        .fixed-head p {
            line-height: 40px;
            font-weight: bold;
            font-size: 17px;
            text-align: center;
        }

        .global-table td:nth-child(3), .global-table td:nth-child(5) {
            text-align: right;
        }
        
        .global-table td:nth-child(4) {
            text-align: center;
        }
    </style>
    <body>
        <div class="fixed-head">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-lg-10">
                        <p>Zvoleno <span class="global_count">0</span> kusů za <span class="global_price">0</span> Kč s DPH</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="case mt-5">
            <?php
            while ($row_main = mysqli_fetch_array($main_groups)) {
                $last_title = $row_main['title'];
                $products = mysqli_query($connect, "SELECT products.sid, products.description, products.price, groups.title FROM products LEFT JOIN product_assoc ON products.id = product_assoc.product_id LEFT JOIN groups ON groups.id = product_assoc.group_id WHERE product_assoc.group_id={$row_main['id']} OR product_assoc.group_id IN (SELECT group_id FROM group_assoc WHERE subgroup_of={$row_main['id']})");
                ?>
                <div class="container mt-3">
                    <div class="row justify-content-md-center">
                        <div class="card col-lg-10">
                            <div class="row card-header">
                                <div class="col-6">
                                    <h2 class="float-start"><?= $row_main['title'] ?></h2>
                                </div>
                                <div class="col-6">
                                    <p class="float-end"><button class="btn btn-primary rollup" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBlock<?= $row_main['id'] ?>" aria-expanded="true" aria-controls="collapseBlock<?= $row_main['id'] ?>"><i class="fa-solid fa-chevron-down"></i></button></p>
                                </div>
                            </div>
                            <div class="collapse" id="collapseBlock<?= $row_main['id'] ?>">
                                <div class="card-body px-4">
                                    <table class="table table-sm table-striped table-hover">
                                        <?php while ($product = mysqli_fetch_array($products)) { ?>
                                            <?php if ($last_title != $product['title']) { ?>
                                            </table>
                                            <h3><?= $product['title'] ?></h3>
                                            <table class="table table-sm table-striped">
                                            <?php } ?>
                                            <tr data-sid="<?= $product['sid'] ?>">
                                                <td><?= $product['sid'] ?></td>
                                                <td class="name"><?= $product['description'] ?></td>
                                                <td data-price="<?= $product['price'] ?>" class="price"><?= number_format($product['price'], 0, ",", "&nbsp;"); ?></td>
                                                <td><input style="width: 70px" data-product="<?= $product['sid'] ?>" class="form-control" type="number" value="0" min="0"></td>
                                                <td class="line" data-price="0">0</td>
                                            </tr>
                                            <?php
                                            $last_title = $product['title'];
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="container mt-3">
                <div class="row justify-content-md-center">
                <hr>
                    <div class="card col-lg-10">
                        <div class="row card-header">
                            <h4>Soupis položek</h4>
                        </div>
                        <div class="card-body px-4">
                            <table class="global-table table table-sm table-striped table-hover">
                                <tbody></tbody>
                            </table>
                            <button id="exportButton" class="btn btn-primary">Vytvořit soupis</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/js/jquery.min.js" type="text/javascript"></script>
        <script src="/js/jquery.formatNumber.min.js" type="text/javascript"></script>
        <script src="/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/fontawesome/js/all.min.js" type="text/javascript"></script>
        <script src="js/behavior.js?v=<?= $force_load ?>" type="text/javascript"></script>
        <script src="js/downloadTextFile.js" type="text/javascript"></script>
        <script src="/js/exportData.js" type="text/javascript"></script>

        <script>
    // Trigger the export when the button is clicked
    $('#exportButton').click(function () {
        downloadTextFile(function () {
            console.log('File download completed.');
        });
    });
</script>

    </body>
</html>
